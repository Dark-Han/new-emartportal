<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Tool */
class ToolResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id' => $this->id,
            'tool_type_id' => $this->toolType->id,
            'tool_type_name' => $this->toolType->name,
            'serial_number' => $this->serial_number,
        ];
    }
}
