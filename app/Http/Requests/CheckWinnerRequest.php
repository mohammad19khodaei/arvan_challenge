<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckWinnerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone' => [
                'required', 
                'string', 
                'regex:/^(0|\+98)?9(1[0-9]|9[0-2]|2[0-2]|0[1-5]|41|3[0,3,5-9])\d{7}$/'
            ]
        ];
    }
}
