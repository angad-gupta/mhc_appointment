<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'phone' => 'required',
            'mail' => 'email|required',
            'address' => 'required',
            'google_map' => 'nullable',
            'fb_link' => 'nullable|url',
            'twitter_link' => 'nullable|url',
            'linked_in_link' => 'nullable|url',
            'instragram_link' => 'nullable|url',
        ];
    }
}
