<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tool extends Model
{
    use SoftDeletes, HasFactory;

    protected $guarded = [];
    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i'
    ];

    public function toolType(): BelongsTo
    {
        return $this->belongsTo(ToolsTypes::class);
    }
}
