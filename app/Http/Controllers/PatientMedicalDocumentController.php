<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\PatientMedicalDocument;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PatientMedicalDocumentController extends Controller
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
        return view('operations.patient-document.create', [
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
        $this->validate($request, [
            'appointment_id' => 'required',
            'patient_id' => 'required',
            'document' => 'required|mimes:jpeg,bmp,png,gif,svg,pdf'
        ]);

        $medical_document = new PatientMedicalDocument();
        $medical_document->fill($request->all());
        $medical_document->directory = uploadFile($request->document, 'medical-document');
        if ($medical_document->save()) {

            if ($request->query('redirect_back') == 1) {
                return redirect()->back()->with('success', __('actions.success_message', ['attribute' => __('document.patient_document')]));
            }

            $appointment = Appointment::findOrFail(decrypt($request->appointment_id));
            return redirect()->route('prescription.create', 'patient=' . encrypt($appointment->patient_id) . '&appointment=' . encrypt($appointment->id) . '#tab_2')
                ->with('success', __('actions.success_message', ['attribute' => __('document.patient_document')]));
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
     * Display patient medical document by patient id
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function medicalDocuments($id)
    {
        try {
            $patient_id = decrypt($id);
        } catch (\Exception $e) {
            abort(404);
        }

        return view('operations.patient.medical-documents', [
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
        $document_id = decrypt($id);
        if (PatientMedicalDocument::destroy($document_id)) {

            if (request()->query('redirect_back') == 1) {
                return redirect()->back()->with('success', __('actions.delete_message', ['attribute' => __('document.patient_document')]));
            }

            $appointment = Appointment::findOrFail(decrypt($request->appointment_id));
            return redirect()->route('prescription.create', 'patient=' . encrypt($appointment->patient_id) . '&appointment=' . encrypt($appointment->id) . '#tab_2')
                ->with('success', __('actions.delete_message', ['attribute' => __('document.patient_document')]));

        }
    }
}
