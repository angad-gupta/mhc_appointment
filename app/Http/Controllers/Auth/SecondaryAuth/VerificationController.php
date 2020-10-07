<?php

namespace App\Http\Controllers\Auth\SecondaryAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Session;
use Carbon\Carbon;
use Auth;
use App\Models\Patient;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = '/patient/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('guest:extra_user');
    }

    public function show(Request $request)
    {
        $user = Session::get('loggedUser');
        if(!$user) return redirect('patient/login');

        return view('auth.patient_verify');
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function verify(Request $request)
    {
        $user = User::where('is_vendor',0)->where('activation_code',$request->route('code'))->first();
        if(!$user)
            abort(404);

        if ($user->email_verified_at) {
            return redirect('patient/login')->with('error','The Email Address has already been verified.');
        }

        $user->email_verified_at = Carbon::now();
        $user->save();

        $patient = Patient::where('user_id', $user->id)->first();
        if(!$patient) {
            $patient = new Patient();
            $patient->full_name = $user->name;
            $patient->contact_email = $user->email;
            $patient->photo = $user->photo;
            $patient->cell_phone = $user->phone_number;
            $patient->user_id = $user->id;
            $patient->sex = $user->gender;
            $patient->date_of_birth = $user->dob;
            $patient->save();
        }
                 
        \Session::flash('success','Account verified successfully!');
        
        Auth::guard('extra_user')->login($user); 
        return redirect()->to('patient/home');
    }

    /**
     * Resend the email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resend(Request $request)
    {
        $user = Session::get('loggedUser');
        if(!$user) return redirect('patient/login');

        $user->sendEmailVerificationNotification();

        return back()->with('resent', true);
    }

    public function redirectTo(){
        return Session::has('url.intended') ? Session::get('url.intended') : $this->redirectTo;
    }
}
