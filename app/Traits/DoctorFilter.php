<?php


namespace App\Traits;


use App\Models\Doctor;
use Illuminate\Http\Request;

trait DoctorFilter
{

    /**
     * Filter doctor
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getFeltedDoctor(Request $request)
    {
        $doctor = Doctor::query();

        if ($request->query('q') != null) {
            $doctor->where('full_name', 'like', '%' . $request->query('q') . '%')
                ->orWhere('phone', 'like', '%' . $request->query('q') . '%');
        }

        $orderType = $request->query('order') == 'asc' ? 'asc' : 'desc';
        $doctor->orderBy('id', $orderType);

        return $doctor;
    }

}