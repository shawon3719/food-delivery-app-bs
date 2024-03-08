<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRestaurantRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'lat' => 'required|string',
            'long' => 'required|string'
        ];
    }
}