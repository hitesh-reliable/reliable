<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class CreatePoll extends BaseRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'pollName' => 'required|string',
            'pollDescription' => 'required|string',
            'pollTiming' => 'required|date_format:Y-m-d H:i:s|after_or_equal:now',
            'pollOptions' => 'required|array|min:2'
        ];
    }

    public function messages() {
        return [
            'pollName.required' => 'Please enter poll name',
            'pollName.string' => 'Invalid poll name',
            'pollDescription.required' => 'Please enter poll description',
            'pollDescription.string' => 'Invalid poll description',
            'pollTiming.required' => 'Please enter date and time(ex : 1990-12-24 14:52:20)',
            'pollTiming.date_format' => 'Invalid poll timing',
            'pollTiming.after_or_equal' => 'Timing cannot be less then now.',
            'pollOptions.required' => 'The poll options is required.',
            'pollOptions.min' => 'The poll options must have at least 2 items.',
            'pollOptions.array' => 'The poll options must be an list.',
        ];
    }

}
