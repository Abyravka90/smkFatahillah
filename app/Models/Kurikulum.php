<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Kurikulum extends Model
{
    //
    protected $guarded = [];

    public function image() : Attribute{
        return Attribute::make(
            get: fn($value)=> url('/storage/kurikulum/'.$value),
        );
    }
}
