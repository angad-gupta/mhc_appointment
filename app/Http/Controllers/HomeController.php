<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Appointment;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard by auth role.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carbon = Carbon::now()->addMinutes(10);
        $currentTime = $carbon->totimestring();
        if (auth()->user()->role == 1) {
            return view('operations.dashboard.admin');
        }
        if (auth()->user()->role == 2) {
            $appointment = Appointment::where('doctor_id', auth()->user()->doctor->id)->get();
            
            foreach ($appointment as $app) {
                $time = (explode("To", $app->schedule_time));
                $startTime = date('H:i:s', strtotime($time[0]));
                
                if($startTime == $currentTime ) {
                    \Session::flash('appointment_starting','Your Appointment is about to start.');
                } else {
                    \Session::flash('appointment_starting','Your Appointment is about to start.');
                }
            }

            return view('operations.dashboard.doctor');
        }
        if (auth('extra_user')->check()) {

            return view('website.patient.home');
        }
        if (auth()->user()->role == 4) {
            return view('operations.dashboard.assistant');
        }

    }
}
