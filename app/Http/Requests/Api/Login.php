<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class Login extends BaseRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'email' => 'required|email',
            'password' => 'required'
        ];
    }

    public function messages() {
        return [
            'email.required' => 'Please enter email',
            'email.email' => 'Invalid Email',
            'password.required' => 'Please enter password'
        ];
    }

}
