<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\PatientMedicalDocument;
use App\Models\PatientMedicalNote;
use App\Models\PatientPayment;
use App\Models\Prescription;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Support\Facades\Hash;

class PatientOperationController extends Controller
{
    /**
     * Shows appointment by authenticate patient user
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function appointments()
    {

        $appointments = Appointment::where('patient_id', auth()->user()->patient->id)->whereHas('payments')->orderBy('created_at', 'desc');

        if (request()->query('search') != '') {
            $appointments->where('search_id', 'like', '%' . request()->query('search') . '%');
        }

        return view('website.patient.appointments', [
            'appointments' => $appointments->paginate(12)
        ]);
    }

    /**
     * Get appointment by authenticate patient and appointment id
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function appointment($id)
    {
        return view('website.patient.single-appointment', [
            'appointment' => Appointment::findOrFail(decrypt($id))
        ]);
    }

    /**
     * Get prescriptions by authenticate patient
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function prescriptions()
    {
        return view('website.patient.prescriptions', [
            'prescriptions' => Prescription::where('patient_id', auth()->user()->patient->id)->paginate(12)
        ]);
    }

    /**
     * Get payments by authenticate patient
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function payments()
    {
        $payments = PatientPayment::where('patient_id', auth()->user()->patient->id)->orderBy('created_at', 'desc');

        return view('website.patient.payments', [
            'payments' => $payments->paginate(12)
        ]);
    }

    /**
     * Get notes by authenticate patient
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function notes()
    {
        $notes = PatientMedicalNote::where('patient_id', auth()->user()->patient->id)->orderBy('created_at', 'desc');
        return view('website.patient.notes', [
            'notes' => $notes->paginate()
        ]);
    }

    /**
     * Get document by authenticate patient
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function documents()
    {
        $documents = PatientMedicalDocument::where('patient_id', auth()->user()->patient->id)->orderBy('created_at', 'desc');
        return view('website.patient.documents', [
            'documents' => $documents->paginate(12)
        ]);
    }

    /**
     * Vew patient account
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */


    public function updateAccount(Request $request)
    {
        $patient = Patient::findOrFail(auth()->user()->patient->id);
        $patient->fill($request->all());
        $patient->date_of_birth = Carbon::parse($request->date_of_birth);

        if ($request->hasFile('photo')) {
            $patient->photo = save_image($request->photo, '/uploads/patients/', 400);
        }

        if ($patient->save())
            return redirect()->back()->with('account_update', __('website.patient.account_update_success'));
    }

    /**
     * Show patient settings where patient can change there password , username and email address
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function setting()
    {
        return view('website.patient.setting');
    }

    public function updatePassword(ChangePasswordRequest $request)
    {
        if ($this->isCurrentPasswordMatched($request->current_password)) {
            $user = auth('extra_user')->user();
            $user->password = Hash::make($request->password);
            if ($user->save()) {

                if ($request->query('red')) {
                    return redirect()->back()->with('update_password', 'Password has been updated successfully');
                }

                return response()->json(['Success', 'Password has been updated successfully'], 200);
            }
        } else {
            return redirect()->back()->with('error', 'Current Password Does not matched');
        }
    }

    private function isCurrentPasswordMatched($password)
    {
        if (Hash::check($password, auth('extra_user')->user()->getAuthPassword())) {
            return true;
        } else {
            return false;
        }

    }
}
