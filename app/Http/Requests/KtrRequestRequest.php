<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class KtrRequestRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'required|string',
            'job' => 'required|string',
            'address' => 'required|string',
            'act_as' => 'required|string',
            'road' => 'required|string',
            'subdistrict_id' => 'required|string',
            'district_id' => 'required|string',
            'regency_id' => 'required|string',
            'land_area' => 'required|string',
            'land_status' => 'required|string',
            'purpose' => 'required|string',
            'latitude' => 'required|string',
            'longitude' => 'required|string',
            'ktp_file' => 'required|string',
            'land_document' => 'required|string',
            'activity_location' => 'required|string',
            'sign' => 'required|string',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validasi gagal',
            'errors' => $validator->errors(),
        ], 422));
    }
}
