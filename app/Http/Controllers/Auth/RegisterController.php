<?php

namespace App\Http\Controllers\Auth;

use Session;
use Carbon\Carbon;
use App\User;
use App\Models\Doctor;
use App\Models\Schedule;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
    protected $redirectTo = '/home';

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

    public function showRegistrationForm()
    {
        return view('auth.register', [
            'departments' => Department::all(),
        ]);
    }

    public function RegisterDoctors(Request $request)
    {
        
        $this->validate($request, [
            'title' => 'required',
            'full_name' => 'required',
            'email' => 'required|unique:users',
            'department_id' => 'required|exists:departments,id',
            'sex' => 'required|in:Male,Female,Others',
            'nmc_number' => 'required|unique:doctors,nmc_number',
            'qualification' => 'required',
            'phone_number' => 'required',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6'
        ]);
        $user = new User();
        $user->role = 2;
        $user->status = 0;
        $user->password = bcrypt($request->password);
        $user->fill($request->all());
        if ($user->save()) {
            $doctor = new Doctor();
            $doctor->user_id = $user->id;
            $doctor->doctor_status = 'pending';
            $doctor->fill($request->all());
            // dd($doctor);
            if ($doctor->save()) { 
                $this->saveSchedule($doctor);       
                \Session::flash('success','Congratulations you are just one step away from getting listed. We will contact you soon to verify your account');
                return redirect()->route('/');
            }
        }
    }

    private function saveSchedule(Doctor $doctor)
    {
        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        foreach ($days as $key => $day) {
            $schedule = new Schedule();
            $schedule->day = $day;
            $schedule->day_index = $key;
            $schedule->doctor_id = $doctor->id;
            $schedule->save();
        }
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

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
