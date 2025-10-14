<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class TeknikKendaraanRingan extends Model
{
    //
    protected $guarded = [];

    public function image() : Attribute{
        return Attribute::make(
            get:fn($value) => url('storage/tkr/'.$value),
        );
    }
}
