<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Photo extends Model
{
    //
    USE HasFactory;
    protected $guarded = [];

    public function image() :Attribute
    {
        return Attribute::make(
            get:fn($value) => url('/storage/photos/'.$value),
        );
    }
}
