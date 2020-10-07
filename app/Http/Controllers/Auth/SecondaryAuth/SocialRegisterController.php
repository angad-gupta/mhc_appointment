<?php

namespace App\Http\Controllers\Auth\SecondaryAuth;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\SocialProvider;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Socialite;
use Carbon\Carbon;

class SocialRegisterController extends Controller
{

    public function __construct()
    {

    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback(Request $request,$provider)
    {
        if (!$request->has('code') || $request->has('denied')) {
            return redirect()->route('patient.login');
        }

        try
        {
            $socialUser = Socialite::driver($provider)->user();
        }
        catch(\Exception $e)
        {
            return redirect('/');
        }
        //check if we have logged provider
        $socialProvider = SocialProvider::where('provider_id',$socialUser->getId())->first();

        if(!$socialProvider)
        {
            if (!User::where('email', '=', $socialUser->email)->exists()) {
                //create a new user and provider

                if(!$socialUser->email){
                    Session::flash('error','Email Address is required');
                    return redirect()->route('patient.login');
                }

                $user = new User;
                $user->email = $socialUser->email;
                $user->name = $socialUser->name;
                $user->photo = $socialUser->avatar_original;
                $user->is_provider = 1;
                $user->email_verified_at = Carbon::now();
                $user->affilate_code = $socialUser->name.$socialUser->email;
                $user->affilate_code = md5($user->affilate_code);
                $user->user_type = 'Customer';
                $user->save();

                $user->socialProviders()->create(
                    ['provider_id' => $socialUser->getId(), 'provider' => $provider]
                );
                
            }else {
                $user = User::where('email','=',$socialUser->email)->first();
                if($user->is_vendor != 0 || !in_array($user->user_type,['Customer','user'])){
                    Session::flash('error','User not found.');
                    return redirect()->route('patient.login');
                }
                $user->is_provider = 1;
                
                if(!$user->photo){
                    $user->photo = $socialUser->avatar_original;
                }
                if (!$user->email_verified_at) {
                    $user->email_verified_at = Carbon::now();
                }

                $user->save();

                $user->socialProviders()->create(
                    ['provider_id' => $socialUser->getId(), 'provider' => $provider]
                );
            }

        }
        else
        {
            $user = $socialProvider->user;

            if($user->is_vendor != 0 || !in_array($user->user_type,['Customer','user'])){
                Session::flash('error','User not found.');
                return redirect()->route('patient.login');
            }
            if ($user->email_verified_at) {
                $user->email_verified_at = Carbon::now();
                $user->save();
            }
        }

        $patient = Patient::where('user_id', $user->id)->first();
        if($patient == null) {
            Patient::create([
                'user_id' => $user->id,
                'full_name' => $user->name,
                'photo' => $user->photo,
                'contact_email' => $user->email,
                'date_of_birth' => $user->dob,
                'sex' => $user->gender,
                'cell_phone' => $user->phone,
                'city' => $user->city,
                'address' => $user->address,
            ]);
        }

        Auth::guard('extra_user')->login($user); 
        return redirect()->to('patient/home');
    }
}
