<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKtrRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'job' => 'nullable|string',
            'address' => 'nullable|string',
            'act_as' => 'nullable|string',
            'road' => 'nullable|string',
            'subdistrict_id' => 'nullable|integer',
            'district_id' => 'nullable|integer',
            'regency_id' => 'nullable|integer',
            'land_area' => 'nullable|numeric',
            'land_status' => 'nullable|string',
            'purpose' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'status' => 'nullable|string|in:pending,approved,rejected,waiting_approval',
            // Tambahkan validasi lainnya sesuai kebutuhan
        ];
    }
}
