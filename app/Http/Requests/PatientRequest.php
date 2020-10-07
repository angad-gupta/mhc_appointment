<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientRequest extends FormRequest
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
            'title' => 'required',
            'full_name' => 'required',
            'photo' => 'nullable|image',
            'date_of_birth' => 'required|date|before:today',
            'cell_phone' => 'required|min:6',
            'sex' => 'required',
            'email' => 'nullable|email',
            'contact_email' => 'nullable|email',
            'password' => 'nullable|min:5|max:20|confirmed',
            'password_confirmation' => 'nullable'
        ];


    }
}
