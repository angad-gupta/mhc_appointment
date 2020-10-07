<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:extra_user');
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

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAdminLoginForm()
    {
        return view('auth.admin.login');
    }

    public function checkAdminLogin(Request $request)
    {
        $request->validate(['email' => 'required|email', 'password' => 'required|string']);

        $email = $request->email;
        $password = $request->password;

        $user = User::where('email', $email)->first();
        
        if ($user) {
            if (!(Hash::check($password, $user->password))) return redirect()->back()->with("error", "Password mismatched with your account password. Please try again.");

            if($user->role != 1) return redirect()->back()->with("error", "Only admin login from here.");
            
            Auth::login($user);
        }
        
        return redirect()->back()->with("error", "User not found");
    }

    public function checkDoctorLogin(Request $request)
    {
        $request->validate(['email' => 'required|email', 'password' => 'required|string']);

        $email = $request->email;
        $password = $request->password;

        $user = User::where('email', $email)->first();
         
        if ($user) {
            if (!(Hash::check($password, $user->password))) return redirect()->back()->with("error", "Password mismatched with your account password. Please try again.");

            if($user->role != 2) return redirect()->back()->with("error", "Only doctor login from here.");
            
            Auth::login($user);
        }
        
        return redirect()->back()->with("error", "User not found");
    }
}
