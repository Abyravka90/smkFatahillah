<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Keislaman extends Model
{
    protected $table = 'keislamans';

    protected $guarded = [];

    public function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? url('/storage/keislaman/' . $value) : null,
        );
    }
}
