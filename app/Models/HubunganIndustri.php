<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class HubunganIndustri extends Model
{
    protected $guarded = [];

    public function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? url('/storage/hubungan_industri/' . $value) : null,
        );
    }
}

