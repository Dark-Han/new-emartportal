<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'address' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
