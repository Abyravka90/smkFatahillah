<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class SaranaPrasarana extends Model
{
    protected $guarded = [];

    public function documents(): MorphMany
    {
        return $this->morphMany(DivisionDocument::class, 'documentable');
    }

    public function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? url('/storage/sarana_prasarana/'.$value) : null,
        );
    }

    public function profilePhoto(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? url('/storage/sarana_prasarana/profile_photos/'.$value) : null,
        );
    }
}
