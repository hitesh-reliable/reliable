<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class PollVoting extends BaseRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'pollId' => 'required',
            'optionId' => 'required'
        ];
    }

    public function messages() {
        return [
            'pollId.required' => 'Please enter poll Id.',
            'optionId.required' => 'Please select option.',
        ];
    }

}
