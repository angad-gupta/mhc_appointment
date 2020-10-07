<?php

namespace App\Http\Controllers\Auth\SecondaryAuth;

use Session;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest:extra_user');
        $this->middleware('guest');
    }

    public function ShowPatientRegistrationForm()
    {
        return view('auth.register_patient');
    }

    public function RegisterPatients(Request $request)
    {
        $this->validate($request, [
            'full_name' => 'required',
            'email' => 'required|unique:mysql_2.users',
            'gender' => 'required|in:Male,Female,Others',
            'phone_number' => 'required',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
        ]);
        $user = new User();
        $user->name = $request->full_name;
        $user->email = $request->email;
        $user->phone = $request->phone_number;
        $user->dob = Carbon::parse($request->date_of_birth);
        $user->gender = $request->gender;
        $user->user_type = 'Customer';
        $user->password = bcrypt($request->password);
        $user->activation_code = Str::random(60);
        $status = $user->save();
        
        $request->session()->put('loggedUser', $user);
      
        $user->sendEmailVerificationNotification();
        return redirect()->route('patient_verification.notice');

        // if ($status) {
        //     $patient = new Patient();
        //     // $patient->fill($request->all());
        //     $patient->full_name = $user->name;
        //     $patient->contact_email = $user->email;
        //     $patient->cell_phone = $user->phone_number;
        //     $patient->user_id = $user->id;
        //     $patient->sex = $user->gender;
        //     $patient->date_of_birth = $user->dob;
        //     $patient->save();
                 
        //     \Session::flash('success','Account created succesfully!');
        //     Auth::guard('extra_user')->login($user);
        //     return redirect()->to('patient/home');
        // }

        \Session::flash('error','Registration Failed!');
        return redirect()->back();
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }
}
