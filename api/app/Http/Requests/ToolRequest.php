<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ToolRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'tool_type_id' => ['required', 'integer'],
            'serial_number' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
