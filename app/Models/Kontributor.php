<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Kontributor extends Model
{
    //
    protected $guarded = [];

    public function jurusan(){
        return $this->belongsTo(Jurusan::class);
    }
   
}
