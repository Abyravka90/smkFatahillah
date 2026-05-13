<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class SaranaPrasarana extends Model
{
    protected $guarded = [];

    public function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? url('/storage/sarana_prasarana/' . $value) : null,
        );
    }
}

