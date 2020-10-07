<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;

class PatientHomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:extra_user');
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
        
        $userId = auth()->user()->id;

        $patient = Patient::where('user_id', $userId)->first();

        $payment = \App\Models\PatientPayment::where('patient_id', $patient->id);
        $appointment = \App\Models\Appointment::where('patient_id', $patient->id);
        $prescription = \App\Models\Prescription::where('patient_id', $patient->id);
        $document = \App\Models\PatientMedicalDocument::where('patient_id', $patient->id);
        $note = \App\Models\PatientMedicalNote::where('patient_id', $patient->id);
        $carbon = \Carbon\Carbon::now();

        return view('website.patient.home', compact('payment', 'appointment', 'prescription', 'document', 'note', 'carbon', 'patient'));
    }
}
