<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class DivisionDocument extends Model
{
    protected $guarded = [];

    protected $appends = ['file'];

    public function documentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function file(): Attribute
    {
        return Attribute::make(
            get: fn () => url('/storage/'.$this->folder.'/documents/'.$this->filename),
        );
    }
}
