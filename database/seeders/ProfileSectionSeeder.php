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
        // Find the first profile to update
        $profile = Profile::first();

        if ($profile) {
            DB::table('profiles')->where('id', $profile->id)->update([
                'sejarah_content' => '<h2>Sejarah Singkat</h2><p>SMK Fatahillah Cileungsi didirikan pada tahun 2008 dengan tujuan untuk menyediakan pendidikan kejuruan yang berkualitas dan relevan dengan kebutuhan industri di wilayah Cileungsi dan sekitarnya.</p>',
                'struktur_organisasi_image' => 'placeholders/struktur.png',
                'visi_misi_content' => '<h2>Visi</h2><p>Menjadi lembaga pendidikan vokasi terdepan yang menghasilkan lulusan berakhlak mulia, kompeten, dan berdaya saing global.</p><h2>Misi</h2><ol><li>Meningkatkan kualitas pembelajaran berbasis teknologi.</li><li>Mengembangkan karakter siswa yang religius dan bertanggung jawab.</li><li>Menjalin kemitraan strategis dengan dunia industri.</li></ol>',
                'hymne_fatahillah_content' => '<h2>Hymne Fatahillah</h2><p>Dengan semangat membara, kami melangkah maju. Mengukir prestasi, untuk nusa dan bangsa. Fatahillah jaya, selamanya...</p>',
                'mars_fatahillah_content' => '<h2>Mars Fatahillah</h2><p>Bangkitlah pemuda harapan bangsa, bersama SMK Fatahillah. Siap berkarya, membangun negeri, menuju Indonesia yang mandiri.</p>',
            ]);
        }
    }
}
