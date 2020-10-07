<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceSettingRequest extends FormRequest
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
            'currency_symbol' => 'required',
            'currency_name' => 'required',
            'invoice_text' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required'
        ];
    }
}
