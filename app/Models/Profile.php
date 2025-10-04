<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    //
    protected $guarded = [];

    public function image(): Attribute{
        return Attribute::make(
            get:fn($value)=>url('storage/profile/'.$value),
        );
    }
}
