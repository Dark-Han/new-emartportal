<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShiftRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'openingDate' => ['required', 'date'],
            'closingDate' => ['required', 'date'],
            'shop_id' => ['required', 'exists:shops'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
