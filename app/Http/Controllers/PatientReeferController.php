<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\DoctorsPatients;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientReeferController extends Controller
{

    /**
     * Append doctor to patient
     *
     * @param $patient_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function appendedDoctor($patient_id)
    {
        $doctor_patients = DoctorsPatients::where('patient_id', $patient_id)->pluck('doctor_id');
        $appended_doctors = Doctor::whereIn('id', $doctor_patients)->with('department')->get();
        return response()->json($appended_doctors);
    }

    /**
     * Detached doctor to patient
     *
     * @param $patient_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function detachedDoctor($patient_id)
    {
        $appended_doctors = DoctorsPatients::where('patient_id', $patient_id)->pluck('doctor_id');
        $detached_doctor = Doctor::whereNotIn('id', $appended_doctors)->with('department')->get();
        return response()->json($detached_doctor);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $doctor_patient = new DoctorsPatients();
        $doctor_patient->doctor_id = $request->doctor_id;
        $doctor_patient->patient_id = $request->patient_id;
        $doctor_patient->created_by = auth()->user()->id;
        if ($doctor_patient->save()) {
            return response()->json($doctor_patient);
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
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $patient_id = decrypt($id);
        } catch (\Exception $ex) {
            abort(404);
        }
        return view('operations.patient-reefer.edit', [
            'patient' => Patient::findOrFail($patient_id)
        ]);
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
    public function destroy($id)
    {
        //
    }
}
