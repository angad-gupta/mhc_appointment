<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'doctor_id' => 'required',
            'schedule_date' => 'required|date',
            'schedule_id' => 'required',
            'patient_id' => 'required',
            'payment_amount' => 'nullable|numeric|min:1'
        ];
    }

    public function attributes()
    {
        return [
            'doctor_id' => trans('doctor.doctor'),
            'schedule_date' => trans('schedule.date'),
            'schedule_id' => trans('schedule.schedule'),
            'patient_id' => trans('patient.patient')
        ];
    }
}
