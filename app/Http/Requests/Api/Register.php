<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class Register extends BaseRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|passwordRegex',
        ];
    }

    public function messages() {
        return [
            'name.required' => 'Please Enter Name',
            'name.string' => 'Invalid Name',
            'email.required' => 'Please Enter Email',
            'email.email' => 'Invalid Email',
            'email.unique' => 'Email Already Taken',
            'password.required' => 'Please enter confirm password',
        ];
    }

}
