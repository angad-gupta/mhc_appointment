<?php


namespace App\Traits;


use App\Models\DoctorsPatients;
use App\Models\Patient;
use Illuminate\Http\Request;

trait PatientFilter
{
    /**
     * Filter patient
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function filterPatient(Request $request)
    {
        $patient = Patient::query();
        if ($request->query('query') != null) {
            $patient->where('full_name', 'like', '%' . $request->query('query') . '%');
        }

        if ($request->query('order') != null) {
            $orderType = $request->query('order') == 'asc' ? 'asc' : 'desc';
            $patient->orderBy('id', $orderType);
        }

        return $patient;
    }

    /**
     * Filter patient for doctor
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function filterPatientForDoctor(Request $request)
    {
        $doctor_patients_id = DoctorsPatients::where('doctor_id', auth()->user()->doctor->id)->pluck('patient_id');

        $patient = Patient::query();

        if ($request->query('query') != null) {
            $patient->where('full_name','like','%'.$request->query('query').'%')
                ->orWhere('cell_phone','like','%'.$request->query('query').'%')
                ->orWhere('contact_email','like','%'.$request->query('query').'%');
        }

        if ($request->query('order') != null) {
            $orderType = $request->query('order') == 'asc' ? 'asc' : 'desc';
            $patient->orderBy('id', $orderType);
        }

        $patient->whereIn('id', $doctor_patients_id);

        return $patient;
    }
}