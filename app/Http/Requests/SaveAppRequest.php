<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveAppRequest extends FormRequest
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
            'app_name'  => 'required|min:2',
            'app_debug' => 'required',
            'app_local' => 'required',
            'logo'      => 'nullable|image',
            'banner'    => 'nullable|image'
        ];
    }
}
