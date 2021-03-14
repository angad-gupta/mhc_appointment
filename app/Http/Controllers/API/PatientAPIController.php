<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\PatientMedicalDocument;
use App\Models\PatientMedicalNote;
use App\Models\PatientPayment;
use App\Models\Prescription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class PatientAPIController extends Controller
{
    public function appointments(Request $request)
    {
        $appointments = Appointment::where('patient_id', $request->user()->patient->id)->get();
        if (request()->query('search') != '') {
            $appointments->where('search_id', 'like', '%' . request()->query('search') . '%');
        }
        return response()->json($appointments);
    }

    public function SearchAppointment(Request $request)
    {
       
        $appointments = Appointment::where('patient_id', $request->user()->patient->id)->where('search_id', 'like', '%' . request()->query('search') . '%')->get();
        return response()->json($appointments);
    }

    /**
     * Get appointment by authenticate patient and appointment id
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function appointment(Request $request)
    {
        $appointment = Appointment::where('patient_id',$request->user()->patient->id)->where('id',$request->id)->first();
        return response()->json($appointment);
    }

    /**
     * Get prescriptions by authenticate patient
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function prescriptions(Request $request)
    {
        $prescriptions = Prescription::where('patient_id', $request->user()->patient->id)->paginate(12);
        return response()->json($prescriptions);
    
    }

    /**
     * Get payments by authenticate patient
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function payments(Request $request)
    {
        $payments = PatientPayment::where('patient_id', auth()->user()->patient->id)->orderBy('created_at', 'desc')->paginate(12);
        return response()->json($payments);
    }

    /**
     * Get notes by authenticate patient
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function notes(Request $request)
    {
        $notes = PatientMedicalNote::where('patient_id', $request->user()->patient->id)->orderBy('created_at', 'desc')->paginate(12);
        return response()->json($notes);
    }

    /**
     * Get document by authenticate patient
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function documents(Request $request)
    {
        $documents = PatientMedicalDocument::where('patient_id', $request->user()->patient->id)->orderBy('created_at', 'desc')->paginate(12);
        return response()->json($documents);
    }

    /**
     * Vew patient account
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */


    public function updateAccount(Request $request)
    {
        $patient = Patient::findOrFail($request->user()->patient->id);
        $patient->fill($request->all());
        $patient->date_of_birth = Carbon::parse($request->date_of_birth);
        if ($request->hasFile('photo')) {
            $patient->photo = save_image($request->photo, '/uploads/patients/', 400);
        }
        if ($patient->save()){
            return response()->json(['status' => 'success', 'message' => 'User Information updated successfully']);
        }            
    }

    public function setting()
    {
        return view('website.patient.setting');
    }
}
