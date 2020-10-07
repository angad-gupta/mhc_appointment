<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\PatientMedicalNote;
use Illuminate\Http\Request;

class PatientMedicalNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            $appointment_id = decrypt($request->query('appointment'));
        } catch (\Exception $ex) {
            abort(404);
        }
        return view('operations.patient-note.create', [
            'appointment' => Appointment::findOrFail($appointment_id)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $patient_medical_note = new PatientMedicalNote();
        $patient_medical_note->fill($request->all());
        if ($patient_medical_note->save()) {
            if ($request->query('redirect_back') == 1) {
                return redirect()->back()->with('success', __('actions.success_message', ['attribute' => __('note.patient_note')]));
            }

            $appointment = Appointment::find($request->appointment_id);
            return redirect()->route('prescription.create', 'patient=' . encrypt($appointment->patient_id) . '&appointment=' . encrypt($appointment->id) . '#tab_3')
                ->with('success', __('actions.success_message', ['attribute' => __('note.patient_note')]));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Display patient medical note by patient id
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function medicalNotes($id)
    {
        try {
            $patient_id = decrypt($id);
        } catch (\Exception $e) {
            abort(404);
        }

        return view('operations.patient.medical-notes', [
            'patient' => Patient::findOrFail($patient_id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        try {
            $appointment_id = decrypt($request->appointment_id);
        } catch (\Exception $ex) {
            abort(500);
        }
        $appointment = Appointment::findOrFail($appointment_id);
        if (PatientMedicalNote::destroy($id)) {
            return redirect()->back()->with('success', __('actions.delete_message', ['attribute' => __('note.patient_note')]));
        }
    }
}
