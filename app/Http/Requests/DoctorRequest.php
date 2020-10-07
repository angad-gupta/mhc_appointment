<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoctorRequest extends FormRequest
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
            'user_name' => 'nullable|alpha_dash',
            'title' => 'required',
            'full_name' => 'required',
//            'phone'         =>  'required',
            'photo' => 'nullable|image',
            'sex' => 'required',
            'department_id' => 'required',
            'email' => 'required|email',
            'password' => 'nullable|min:5|max:20|confirmed',
            'password_confirmation' => 'nullable'
        ];
    }
}
