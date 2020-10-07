<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\InvoiceSetting;
use App\Models\Patient;
use App\Models\PatientPayment;
use App\Traits\PaymentTrait;
use Illuminate\Http\Request;

class PatientPaymentController extends Controller
{

    use PaymentTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('operations.patient-payment.index', [
            'payments' => $this->filterPayment($request)->paginate(20)
        ]);
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
        return view('operations.patient-payment.create', [
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
        $payment = new PatientPayment();
        $payment->doctor_id = auth()->user()->id;
        $payment->fill($request->all());
        if ($payment->save()) {
            $this->appointmentStatusChange($payment);
            if ($request->query('redirect_back') == 1) {
                return redirect()->back()->with('success', 'Patient PaymentTrait has been saved successfully');
            }
            return redirect()->route('prescription.create', 'patient=' . encrypt($payment->patient_id) . '&appointment=' . encrypt($payment->appointment_id) . '#payment')
                ->with('success', 'Patient PaymentTrait has been saved successfully');
        }
    }


    private function appointmentStatusChange(PatientPayment $patientPayment)
    {
        $appointment = Appointment::findOrFail($patientPayment->appointment_id);
        $appointment->status = 3;
        $appointment->save();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $payment_id = decrypt($id);
        } catch (\Exception $ex) {
            abort(404);
        }
        return view('operations.patient-payment.show', [
            'payment' => PatientPayment::findOrFail($payment_id),
            'invoice_setting' => InvoiceSetting::first()
        ]);
    }

    /**
     * Display patient payments by patient id
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function payments($id)
    {
        try {
            $patient_id = decrypt($id);
        } catch (\Exception $e) {
            abort(404);
        }

        return view('operations.patient.payments', [
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
        return view('operations.patient-payment.edit', [
            'payment' => PatientPayment::findOrfail(decrypt($id))
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
        $payment = PatientPayment::findOrfail($id);
        $payment->fill($request->all());
        if ($payment->save()) {
            return redirect()->back()->with('success', 'PaymentTrait has been updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payment = PatientPayment::findOrFail($id);
        if ($payment->delete($id)) {
            return redirect()->route('prescription.create', 'patient=' . encrypt($payment->patient_id) . '&appointment=' . encrypt($payment->appointment_id) . '#payment')
                ->with('success', 'Patient medical note has been saved successfully');
        }
    }

    public function print($id)
    {
        $payment = PatientPayment::findOrFail(decrypt($id));
        // $age = $this->getAgeAtPrescription($prescription);        

        return view('website.patient.print.payment_print', [
            'payment' => $payment,
            // 'age' => $age
        ]);
    }
}
