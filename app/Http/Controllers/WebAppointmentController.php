<?php

namespace App\Http\Controllers;

use App\Http\Requests\WebAppointmentRequest;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Schedule;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use phpDocumentor\Reflection\DocBlock\Tags\Author;

class WebAppointmentController extends Controller
{
    /**
     * Get schedule denials as json
     *
     * @param $date
     * @param $doctor_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getScheduleDetails($date, $doctor_id)
    {
        try {
            $day = Carbon::parse($date)->format('l');
        } catch (\Exception $ex) {

        }
        $schedule = Schedule::where('day', $day)->where('doctor_id', decrypt($doctor_id))->with('scheduleDetails')->first();
        return response()->json($schedule);
    }

    /**
     * Save appointment
     *
     * @param WebAppointmentRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeAppointment(WebAppointmentRequest $request)
    {
      
        $appointment = null;
        // if patient is authenticated
        if (auth()->check()) {
            // create appointment
            $appointment = $this->createAppointment($request, auth()->user()->patient);
        } else {
            if ($request->get('new_user') == 'on') {
                // create patient
                $user = $this->createPatient($request);

                $appointment = $this->createAppointment($request, $user->patient);
              
                // create appointment
            } else {
                // get patient by matching email and password
                $user = User::where('email', $request->email)->where('role', 3)->first();
                if (!Hash::check($request->password, $user->password)) {
                    return redirect()->back()->withInput($request->all())->withErrors(['email' => 'Credentials does not matched ']);
                } else {
                    $appointment = $this->createAppointment($request, $user->patient);
                }
            }
        }
        // send an email to patient
        \Session::flash('appointment_submission','Your Appointment id is <strong>'.$appointment->search_id.'</strong>. Please check your email for further details');
        return redirect()->route('/');
        // return success message
        // return redirect()->route('success', 'title=Appointment submitted&message=Your Appointment id is '.$appointment->search_id.' Please check your email for further details');

    }

    /**
     * Create patient for web appointment
     *
     * @param Request $request
     * @return User
     */
    private function createPatient(Request $request)
    {
        $user = new User();
        $user->fill($request->all());
        $user->password = bcrypt($request->password);
        $user->role = 3;
        if ($user->save()) {
            $patient = new Patient();
            $patient->fill($request->all());
            $patient->user_id = $user->id;
            $patient->date_of_birth = Carbon::parse($request->date_of_birth);
            $patient->save();
        }
        return $user;
    }

    /**
     * Create web appointment
     *
     * @param Request $request
     * @param Patient $patient
     * @return Appointment
     */
    public function createAppointment(Request $request, Patient $patient)
    {
        $appointment = new Appointment();
        $appointment->patient_id = $patient->id;
        //Currently its all video so this would be video for now, later will be needing this condition
        //$appointment->appointment_type = $request->video == 1 ? "video":"clinic";
        $appointment->appointment_type = "video";
        $appointment->status == 'pending';
        $appointment->fill($request->all());
        if ($appointment->save()) {
            return $appointment;
        }
    }
}
