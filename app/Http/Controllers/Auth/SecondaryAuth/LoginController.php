<?php

namespace App\Http\Controllers\Auth\SecondaryAuth;

use App\Models\User;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = 'patient/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:extra_user')->except('logout');
        $this->middleware('guest')->except('logout');
    }

    protected function credentials(Request $request)
    {
        $field = filter_var($request->get($this->username()), FILTER_VALIDATE_EMAIL)
            ? $this->username()
            : 'user_name';

        return [
            $field => $request->get($this->username()),
            'password' => $request->password,
        ];
    }

    public function showPatientLoginForm()
    {
        return view('auth.patient_login');
    }

    public function checkPatientLogin(Request $request)
    {
        $request->validate(['email' => 'required|email', 'password' => 'required|string']);

        $email = $request->email;
        $password = $request->password;

        $user = User::where('is_vendor',0)->whereIn('user_type',['Customer','user'])->where('email', $email)->first();

        if ($user) {
            if (!(Hash::check($password, $user->password))) return redirect()->back()->with("error", "Invalid Credentials. Please try again.");
            
            if(!$user->email_verified_at){

                $request->session()->put('loggedUser', $user);
                return redirect()->route('patient_verification.notice');
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
            // if($user->role != 3) return redirect()->back()->with("error", "Only patient login from here.");

            Auth::guard('extra_user')->login($user,$request->filled('remember'));

            return redirect('patient/home');    

        }
        
        return redirect()->back()->with("error", "User not found");
    }

    protected function guard()
    {
        return Auth::guard('extra_user');
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect()->back();
    }
}
