<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToolsTypes extends Model
{
    use HasFactory;

    protected $table = 'tools_types';

    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s'
    ];
}
