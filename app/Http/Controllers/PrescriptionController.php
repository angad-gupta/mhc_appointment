<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\PrescriptionDrug;
use App\Models\PrescriptionInspection;
use App\Traits\DrugTrait;
use App\Traits\PrescriptionFilter;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{

    use DrugTrait, PrescriptionFilter;

    /**
     * Middleware which allow admin and others to access index and print prescription page
     *
     * PrescriptionController constructor.
     */
    public function __construct()
    {
        $this->middleware('doctor.only')->except('index', 'print');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $prescription = $this->prescriptionFilter($request)->paginate(20);
        return view('operations.prescription.index', [
            'prescriptions' => $prescription,
            'request' => $request
        ]);
    }

    /**
     * Return all prescription in json format of patient by patient id
     *
     * @param $patient_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function prescriptionByPatient($patient_id)
    {
        $prescription = Prescription::where('patient_id', $patient_id)->get();
        return response()->json($prescription, 200);
    }

    /**
     * Return prescriptions in json format using prescription id
     *
     * @param $prescription_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function prescriptionById($prescription_id)
    {
        $prescription = Prescription::with(['drugs', 'inspection'])->findOrFail($prescription_id);
        return response()->json($prescription);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     *
     * hit route
     * route('prescription.create').'?patient='.encrypt($doctors_patient->patient->id).'&schedule='.encrypt(1)
     */
    public function create(Request $request)
    {
        try {
            $patient_id = decrypt($request->query('patient'));
            $appointment = decrypt($request->query('appointment'));
        } catch (\Exception $es) {
            abort(404);
        }
        return view('operations.prescription.create', [
            'patient' => Patient::findOrFail($patient_id),
            'appointment' => Appointment::findOrFail($appointment)
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
            'appointment_id' => 'required'
        ]);
        $prescription = new Prescription();
        $prescription->fill($request->all());
        if ($prescription->save()) {
            foreach ($request->drugs as $drug) {
                $this->storePrescriptionDrug($prescription->id, $drug);
            }
            $this->storePrescriptionInspection($prescription->id, $request->inspection);
            if ($request->next_followup != null) {
                $this->updateAppointmentFollowUpDate($request);
            }
        }
        return response()->json($prescription);
    }

    private function updateAppointmentFollowUpDate(Request $request)
    {
        $appointment = Appointment::findOrFail($request->appointment_id);
        $appointment->next_followup = Carbon::parse($request->next_followup)->toDateString();
        $appointment->save();
    }

    /**
     * Store prescription drug
     *
     * @param $prescription_id
     * @param $drugs
     */
    private function storePrescriptionDrug($prescription_id, $drugs)
    {
        $this->saveDrugIfNotExist($drugs['name']);
        $prescription_drug = new PrescriptionDrug();
        $prescription_drug->prescription_id = $prescription_id;
        $prescription_drug->fill($drugs);
        $prescription_drug->save();
    }

    /**
     * Store Prescription Inspection
     *
     * @param $prescription_id
     * @param $inspection
     */
    private function storePrescriptionInspection($prescription_id, $inspection)
    {
        $prescription_inspection = new PrescriptionInspection();
        $prescription_inspection->prescription_id = $prescription_id;
        $prescription_inspection->fill($inspection);
        $prescription_inspection->save();
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
    public function destroy($id)
    {
        if (Prescription::destroy(decrypt($id))) {
            return redirect()->back()->with('success', 'Prescription has been deleted successfully');
        }
    }

    /**
     * Print Prescription
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function print($id)
    {
        $prescription = Prescription::findOrFail(decrypt($id));
        $age = $this->getAgeAtPrescription($prescription);        

        return view('operations.prescription.print', [
            'prescription' => $prescription,
            'age' => $age
        ]);

    }

    public function getAgeAtPrescription($prescription){
        $age = \Carbon\Carbon::parse($prescription->patient->date_of_birth)->diff($prescription->created_at)->format('%y-%m-%d');
        $years = explode("-", $age);
        if($years[0] > 0){
            return $years[0].' Years';
        }elseif ($years[1] > 0){
            return $years[1].' Months';
        }else{
            return $years[2].' Days';
        }
    }
}
