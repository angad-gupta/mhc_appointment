<?php

namespace App\Http\Controllers;

use App\Models\Drug;
use App\Models\PrescriptionDrug;
use App\Traits\AppointmentFilter;
use App\Traits\PaymentTrait;
use App\Traits\PrescriptionFilter;
use Carbon\Carbon;
use PDF;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    use AppointmentFilter, PrescriptionFilter, PaymentTrait;

    /**
     * Make paf report for appointment
     * @param Request $request
     * @return mixed
     */
    public function appointment(Request $request)
    {
        $appointments = $this->appointmentFilter($request)->get();
        $pdf = PDF::loadView('operations.reports.appointment', compact(['appointments']));
        return $pdf->download('appointment.pdf');
    }

    /**
     * make pdf report for followup
     *
     * @param Request $request
     * @return mixed
     */
    public function followUp(Request $request)
    {
        $appointments = $this->followUpFilter($request)->get();
        $pdf = PDF::loadView('operations.reports.follow-up', compact(['appointments']));
        return $pdf->download('followup.pdf');
    }

    /**
     * Make pdf report for prescription
     *
     * @param Request $request
     * @return mixed
     */
    public function prescription(Request $request)
    {
        $prescriptions = $this->prescriptionFilter($request)->get();
        $pdf = PDF::loadView('operations.reports.prescription', compact(['prescriptions']));
        return $pdf->download('prescription.pdf');
    }

    /**
     * Create drug report
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function drug(Request $request)
    {
        $drug = Drug::query();
        if (auth()->user()->role == 2) {
            $drug->where('department_id', auth()->user()->doctor->department_id);
        }
        return view('operations.reports.drug', [
            'drugs' => $drug->get()
        ]);
    }

    /**
     * Create pdf report for drug
     *
     * @param Request $request
     * @return mixed
     */
    public function drugReportPDF(Request $request)
    {
        $drugs = Drug::query();
        if (auth()->user()->role == 2) {
            $drugs->where('department_id', auth()->user()->doctor->department_id);
        }

        if ($request->query('drug') == null && $request->query('date_range') == null) {
            $_drugs = $drugs->get();
            $pdf = PDF::loadView('operations.reports.drug.all-drug-any-time', compact(['_drugs']));
            return $pdf->download('all-drug-any-time.pdf');

        } elseif ($request->query('drug') != null && $request->query('date_range') == null) {
            $_drug = $drugs->where('id', $request->query('drug'))->firstOrFail();
            $prescription_drugs = PrescriptionDrug::where('name', $_drug->trade_name)->get();
            $pdf = PDF::loadView('operations.reports.drug.drug-any-time', compact(['_drug', 'prescription_drugs']));
            return $pdf->download('drug-any-time.pdf');

        } elseif ($request->query('drug') == null && $request->query('date_range') != null) {
            $_drugs = $drugs->get();
            $range = explode('to ', $request->query('date_range'));
            $pdf = PDF::loadView('operations.reports.drug.all-drug-in-date-range', compact(['_drugs', 'range']));
            return $pdf->download('all-drug-in-range.pdf');

        } elseif ($request->query('drug') != null && $request->query('date_range') != null) {
            $_drug = $drugs->where('id', $request->query('drug'))->firstOrFail();
            $range = explode('to ', $request->query('date_range'));
            $prescription_drugs = PrescriptionDrug::where('name', $_drug->trade_name)
                ->whereBetween('created_at', [Carbon::parse($range[0])->toDateString(), Carbon::parse($range[1])->toDateString()])
                ->get();
            $pdf = PDF::loadView('operations.reports.drug.drug-in-range', compact(['_drug', 'range', 'prescription_drugs']));
            return $pdf->download('drug-in-range.pdf');
        }
    }

    /**
     * Create PDF report for payment
     *
     * @param Request $request
     * @return mixed
     */
    public function payment(Request $request)
    {
        $payments = $this->filterPayment($request)->get();
        $pdf = PDF::loadView('operations.reports.payment', compact('payments'));
        return $pdf->download('payments.pdf');
    }
}
