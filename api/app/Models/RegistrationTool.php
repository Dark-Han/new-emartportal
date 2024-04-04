<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class RegistrationTool extends Model
{
    use SoftDeletes, HasFactory;

    public $timestamps = false;

    protected function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }

    protected function tool(): BelongsTo
    {
        return $this->belongsTo(Tool::class);
    }
}
