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
        // Find the first profile, or create one if it doesn't exist
        $profile = Profile::first();

        if ($profile) {
            DB::table('profiles')->where('id', $profile->id)->update([
                'sejarah_content' => '<p>Ini adalah contoh konten sejarah sekolah. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>',
                'struktur_organisasi_image' => 'placeholders/struktur.jpg', // Placeholder path
                'visi_misi_content' => '<h2>Visi</h2><p>Menjadi lembaga pendidikan vokasi yang unggul.</p><h2>Misi</h2><ol><li>Misi pertama...</li><li>Misi kedua...</li></ol>',
                'hymne_fatahillah_content' => '<p>Lirik Hymne Fatahillah...</p>',
                'mars_fatahillah_content' => '<p>Lirik Mars Fatahillah...</p>',
            ]);
        }
    }
}
