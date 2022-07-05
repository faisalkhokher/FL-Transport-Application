<?php

namespace App\Http\Requests;
use Proengsoft\JsValidation\Facades\JsValidatorFacade as JsValidator;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'password' => 'required|confirmed|min:6',
         
        ];
    }

    public function messages()
    {
        return ['password.required' => 'Password Required'];
    }
}
