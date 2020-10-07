<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Patient;
use Carbon\Carbon;
use App\User;
use GuzzleHttp\Client as Guzzle;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function Register(Request $request)
    {
        $this->validate($request, [
            'full_name' => 'required',
            'email' => 'required|unique:users',
            'gender' => 'required|in:Male,Female,Others',
            'phone_number' => 'required',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6'
        ]);
        $user = User::firstOrNew(['email' => $request->email]);
        $user->fill($request->all());
        $user->password = bcrypt($request->password);
        $user->role = 3;
        if ($user->save()) {
            $http = new Guzzle;
            $response = $http->post(url('oauth/token'), [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => 9,
                    'client_secret' => 'veQJEqU9htWjoOnjXwfmGn04drvb7mE42Tku3ITr',
                    'username' => $request->email,
                    'password' => $request->password,
                    'scope' => '',
                ],
            ]);
            $patient = new Patient();
            $patient->fill($request->all());
            $patient->user_id = $user->id;
            $patient->sex = $request->get('gender');
            $patient->date_of_birth = Carbon::parse($request->date_of_birth);
            $patient->save();
            if ($patient->save()) {   
                return response()->json(['data' => json_decode((string) $response->getBody(), true)]);
            }
        }
    }

    public function Login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $user = User::where('email',$request->email)->first();
        if(!$user){
            return response()->json(['status' => 'error', 'message' => 'User Not found']);
        }

        if ($user->role == 3) {
            if(Hash::check($request->password, $user->password)){
                $http = new Guzzle;
                $response = $http->post(url('oauth/token'), [
                    'form_params' => [
                        'grant_type' => 'password',
                        'client_id' => 9,
                        'client_secret' => 'veQJEqU9htWjoOnjXwfmGn04drvb7mE42Tku3ITr',
                        'username' => $request->email,
                        'password' => $request->password,
                        'scope' => '',
                    ],
                ]); 
                return response()->json(['data' => json_decode((string) $response->getBody(), true)]);
            }
        }
        else{
            return response()->json(['status' => 'error', 'message' => 'User Not found']);
        }

      
    }
}
