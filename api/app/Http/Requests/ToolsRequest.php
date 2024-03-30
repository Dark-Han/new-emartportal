<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ToolsRequest extends FormRequest
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
