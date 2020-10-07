<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Auth;

class WebAppointmentRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::guard('extra_user')->check();
    }

    /**
     * @return array
     */
    public function rules()
    {
        $rules = [];

        $rules['schedule_date'] = 'required';
        $rules['schedule_time'] = 'required';
        $rules['doctor_id'] = 'required';


        if (auth('extra_user')->guest()) {
            $rules['title'] = 'required';
            $rules['full_name'] = 'required';
            $rules['sex'] = 'required';
            $rules['date_of_birth'] = 'required';
            $rules['address'] = 'required';
            $rules['cell_phone'] = 'required';
            $rules['email'] = 'email|required';
            $rules['password'] = 'required|min:4';
        }

        if ($this->get('new_user') == 'on') {

            $rules['email'] = 'unique:users';
            $rules['password'] = 'confirmed';
            $rules['password_confirmation'] = 'required';
        }

        if ($this->get('new_user') != 'on' && auth()->guest()) {
            $rules['email'] = Rule::exists('users')->where('role', 3);
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'email.exists' => "We haven't found this email address is our database. \n please click on new user check box to create an account",
            'schedule_id.required' => 'Please select appointment time',
            'doctor_id.required' => 'Please select a doctor'
        ];
    }


}
