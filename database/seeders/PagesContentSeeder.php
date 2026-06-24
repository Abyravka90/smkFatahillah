<?php

namespace Database\Seeders;

use App\Models\HubunganIndustri;
use App\Models\Keislaman;
use App\Models\SaranaPrasarana;
use Illuminate\Database\Seeder;

class PagesContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Keislaman::firstOrCreate(
            ['name' => 'Keislaman'],
            [
                'name' => 'Keislaman',
                'content' => '<p>Konten Keislaman belum diisi. Silakan update dari panel admin.</p>',
                'image' => null,
            ]
        );

        HubunganIndustri::firstOrCreate(
            ['name' => 'Hubungan Industri'],
            [
                'name' => 'Hubungan Industri',
                'content' => '<p>Konten Hubungan Industri belum diisi. Silakan update dari panel admin.</p>',
                'image' => null,
            ]
        );

        SaranaPrasarana::firstOrCreate(
            ['name' => 'Sarana dan Prasarana'],
            [
                'name' => 'Sarana dan Prasarana',
                'content' => '<p>Konten Sarana dan Prasarana belum diisi. Silakan update dari panel admin.</p>',
                'image' => null,
            ]
        );
    }
}
