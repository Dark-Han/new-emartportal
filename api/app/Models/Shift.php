<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shift extends Model
{
    use SoftDeletes, HasFactory;

    public $timestamps = false;

    protected $casts = [
        'openingDate' => 'datetime',
        'closingDate' => 'datetime',
    ];

    protected function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }
}
