<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRegistrationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'full_name' => ['nullable'],
            'iin' => ['nullable'],
            'document_number' => ['nullable'],
            'document_given_by' => ['nullable'],
            'address' => ['nullable'],
            'phone' => ['nullable'],
            'rent_start_date' => ['nullable', 'date'],
            'rent_end_date' => ['nullable', 'date'],
            'one_day_rent_amount' => ['nullable', 'integer'],
            'paid' => ['required', 'integer'],
            'duty' => ['nullable', 'integer'],
            'consultant_id' => ['nullable', 'integer'],
            'client_type_id' => ['nullable', 'integer'],
            'payment_type_id' => ['nullable', 'integer'],
            'delivery_type_id' => ['nullable', 'integer'],
            'delivery_man_id' => ['nullable', 'integer'],
            'delivery_amount' => ['nullable', 'integer'],
            'rent_tools_ids' => ['required', 'array']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
