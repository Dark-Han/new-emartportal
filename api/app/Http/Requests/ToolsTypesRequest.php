<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ToolsTypesRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Название не заполнено!'
        ];
    }
}
