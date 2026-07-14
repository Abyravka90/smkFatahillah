<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mikrotik extends Model
{
    protected $fillable = [
        'trainer',
        'materi',
        'foto_kegiatan_1',
        'foto_kegiatan_2',
        'foto_kegiatan_3',
        'sertifikat_1',
        'sertifikat_2',
        'sertifikat_3',
        'tentang_mikrotik_academy',
        'sertifikat_trainer',
    ];
}
