<?php

namespace App\Http\Controllers\Auth\SecondaryAuth;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Auth;
use Carbon\Carbon;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
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
        $this->middleware('guest:extra_user');
        $this->middleware('guest');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.patient_reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function broker()
    {
        return Password::broker('extra_users');
    }

    /**
     * Get the guard to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('extra_user');
    }

    protected function resetPassword($user, $password)
    {
        $user->password = Hash::make($password);

        $user->setRememberToken(Str::random(60));

        if(!$user->email_verified_at)
            $user->email_verified_at = Carbon::now();

        $user->save();

        event(new PasswordReset($user));

        $patient = Patient::where('user_id', $user->id)->first();
        if(!$patient) {
            $patient = new Patient();
            $patient->full_name = $user->name;
            $patient->contact_email = $user->email;
            $patient->cell_phone = $user->phone_number;
            $patient->user_id = $user->id;
            $patient->photo = $user->photo;
            $patient->sex = $user->gender;
            $patient->date_of_birth = $user->dob;
            $patient->save();
        }

        $this->guard()->login($user);
    }
}
