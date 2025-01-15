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
            'user_id' => 'required|exists:users,id',
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
            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string',
            'ktp_file' => 'required|file|mimes:pdf,jpg,jpeg,png',
            'land_document' => 'required|file|mimes:pdf,jpg,jpeg,png',
            'activity_location' => 'required|file|mimes:pdf,jpg,jpeg,png',
            'sign' => 'nullable|string',
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
