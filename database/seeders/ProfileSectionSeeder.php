<?php

namespace Database\Seeders;

use App\Models\Profile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfileSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $profile = Profile::first();

        if ($profile) {
            DB::table('profiles')->where('id', $profile->id)->update([
                'sejarah_content' => '<h2>Sejarah Singkat</h2><p>Ini adalah contoh konten sejarah sekolah...</p>',
                'struktur_organisasi_image' => 'placeholders/struktur.png',
                'visi_misi_content' => '<h2>Visi</h2><p>Visi sekolah...</p><h2>Misi</h2><ol><li>Misi 1...</li></ol>',
                'hymne_fatahillah_content' => '<h2>Hymne Fatahillah</h2><p>Lirik hymne...</p>',
                'mars_fatahillah_content' => '<h2>Mars Fatahillah</h2><p>Lirik mars...</p>',
            ]);
        }
    }
}
