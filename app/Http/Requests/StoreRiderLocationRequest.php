<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRiderLocationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'rider_id' => [
                'integer',
                'required',
                'exists:riders,id',
            ],
            'lat' => [
                'string',
                'required'
            ],
            'long' => [
                'string',
                'required'
            ],
            'capture_time' => [
                'date_format:Y-m-d H:i:s',
                'required'
            ]
        ];
    }
}
