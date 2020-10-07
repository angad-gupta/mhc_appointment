<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AboutRequest extends FormRequest
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
        $rule = [
            'about_us' => 'required',
            'opening_hours' => 'required',
            'about_us_video' => 'nullable|url'
        ];

        if ($this->hasFile('about_us_image')) {
            $rule['about_us_image'] = 'image';
        } else {
            $rule['about_us_video'] = 'required';
        }

        return $rule;
    }
}
