<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Registration extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $guarded = [];

    public function actions(): HasMany
    {
        return $this->hasMany(Action::class);
    }
}
