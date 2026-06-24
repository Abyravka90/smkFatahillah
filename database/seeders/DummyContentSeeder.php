<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\DivisionDocument;
use App\Models\Event;
use App\Models\Fasilitas;
use App\Models\HubunganIndustri;
use App\Models\Jurusan;
use App\Models\Keislaman;
use App\Models\KepalaSekolah;
use App\Models\Kesiswaan;
use App\Models\Kontributor;
use App\Models\Kurikulum;
use App\Models\OTKP;
use App\Models\Photo;
use App\Models\Post;
use App\Models\Pramuka;
use App\Models\Profile;
use App\Models\SaranaPrasarana;
use App\Models\Slider;
use App\Models\Spmb;
use App\Models\Tag;
use App\Models\TeknikKomputerJaringan;
use App\Models\Video;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DummyContentSeeder extends Seeder
{
    public function run(): void
    {
        $dummyContent = [
            'kesiswaan' => [
                'model' => Kesiswaan::class,
                'folder' => 'kesiswaan',
                'name' => 'Bimbingan Konseling',
                'paragraphs' => [
                    'Program Bimbingan Konseling (BK) di SMK Fatahillah hadir untuk mendukung perkembangan akademik, sosial, dan emosional peserta didik. Layanan ini bertujuan membantu siswa mengenali potensi diri serta mengatasi hambatan belajar.',
                    'Konselor sekolah memberikan layanan individual maupun kelompok secara berkala. Setiap siswa berhak mendapatkan bimbingan karir, konseling pribadi, serta informasi tentang beasiswa dan perguruan tinggi.',
                    'Kami percaya bahwa setiap siswa memiliki keunikan dan potensi masing-masing. Melalui program BK yang terstruktur, kami mendampingi siswa merencanakan masa depan mereka dengan percaya diri.',
                ],
                'documents' => [
                    ['original_name' => 'Panduan BK 2025.pdf', 'mime_type' => 'application/pdf', 'size' => 204800],
                    ['original_name' => 'Jadwal Konseling Semester 2.xlsx', 'mime_type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'size' => 102400],
                ],
            ],
            'kurikulum' => [
                'model' => Kurikulum::class,
                'folder' => 'kurikulum',
                'name' => 'Kurikulum Merdeka',
                'paragraphs' => [
                    'SMK Fatahillah menerapkan Kurikulum Merdeka yang berfokus pada pengembangan kompetensi dan karakter siswa. Pendekatan ini memberikan fleksibilitas bagi guru untuk merancang pembelajaran yang sesuai dengan kebutuhan peserta didik.',
                    'Struktur kurikulum terdiri dari mata pelajaran umum, kejuruan, dan projek penguatan profil pelajar Pancasila. Setiap semester siswa mengikuti minimal satu projek tematik yang relevan dengan dunia kerja.',
                    'Kami terus melakukan evaluasi dan pengembangan kurikulum secara berkala agar selaras dengan perkembangan industri dan kebutuhan dunia usaha. Kolaborasi dengan mitra industri menjadi kunci dalam penyusunan kurikulum yang relevan.',
                ],
                'documents' => [
                    ['original_name' => 'Struktur Kurikulum 2025.pdf', 'mime_type' => 'application/pdf', 'size' => 307200],
                    ['original_name' => 'Kalender Akademik 2025-2026.pdf', 'mime_type' => 'application/pdf', 'size' => 153600],
                ],
            ],
            'hubungan_industri' => [
                'model' => HubunganIndustri::class,
                'folder' => 'hubungan_industri',
                'name' => 'Kerja Sama Industri',
                'paragraphs' => [
                    'Hubungan Industri (Hubin) SMK Fatahillah menjalin kemitraan strategis dengan berbagai perusahaan dan industri terkemuka. Program ini memfasilitasi Praktek Kerja Lapangan (PKL), kunjungan industri, dan rekrutmen langsung.',
                    'Saat ini kami bekerja sama dengan lebih dari 50 mitra industri nasional yang tersebar di berbagai sektor. Setiap tahun, siswa kami ditempatkan di perusahaan mitra untuk mengasah keterampilan langsung di lapangan.',
                    'Melalui program Hubin, lulusan SMK Fatahillah memiliki daya saing tinggi dan siap terjun ke dunia kerja. Banyak mitra industri yang secara rutin merekrut alumni kami setiap tahunnya.',
                ],
                'documents' => [
                    ['original_name' => 'MoU Mitra Industri 2025.pdf', 'mime_type' => 'application/pdf', 'size' => 512000],
                    ['original_name' => 'Data Penempatan PKL.xlsx', 'mime_type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'size' => 204800],
                ],
            ],
            'keislaman' => [
                'model' => Keislaman::class,
                'folder' => 'keislaman',
                'name' => 'Program Keislaman',
                'paragraphs' => [
                    'Program Keislaman di SMK Fatahillah bertujuan membentuk peserta didik yang beriman, bertakwa, dan berakhlak mulia. Kegiatan keagamaan dilaksanakan secara rutin dan terprogram sepanjang tahun ajaran.',
                    'Kegiatan unggulan meliputi Sholat Dhuha berjamaah, kajian kitab kuning, hafalan Al-Quran, serta peringatan hari besar Islam. Kami juga menyelenggarakan pesantren kilat dan lomba keagamaan antar kelas.',
                    'Pembinaan keislaman tidak hanya berfokus pada aspek ibadah, tetapi juga pada pembentukan karakter Islami dalam kehidupan sehari-hari. Siswa dibiasakan bersikap jujur, disiplin, dan peduli terhadap sesama.',
                ],
                'documents' => [
                    ['original_name' => 'Jadwal Kegiatan Keislaman.pdf', 'mime_type' => 'application/pdf', 'size' => 128000],
                    ['original_name' => 'Materi Kajian Rutin.docx', 'mime_type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'size' => 256000],
                ],
            ],
            'sarana_prasarana' => [
                'model' => SaranaPrasarana::class,
                'folder' => 'sarana_prasarana',
                'name' => 'Fasilitas Sekolah',
                'paragraphs' => [
                    'SMK Fatahillah memiliki sarana dan prasarana yang lengkap untuk mendukung proses belajar mengajar yang optimal. Fasilitas kami meliputi laboratorium komputer, bengkel praktik, perpustakaan digital, dan ruang kelas ber-AC.',
                    'Setiap tahun dilakukan perawatan dan pengadaan sarana baru sesuai kebutuhan. Kami juga memiliki fasilitas olahraga, aula serbaguna, dan area hijau yang nyaman untuk kegiatan ekstrakurikuler.',
                    'Pengelolaan sarana dan prasarana dilakukan secara profesional dengan sistem inventarisasi digital. Setiap aset sekolah tercatat dan dipantau secara berkala untuk memastikan kondisi optimal.',
                ],
                'documents' => [
                    ['original_name' => 'Inventaris Sarana 2025.xlsx', 'mime_type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'size' => 409600],
                    ['original_name' => 'Jadwal Pemeliharaan.pdf', 'mime_type' => 'application/pdf', 'size' => 102400],
                ],
            ],
            'pramuka' => [
                'model' => Pramuka::class,
                'folder' => 'pramuka',
                'name' => 'Kegiatan Pramuka',
                'paragraphs' => [
                    'Kegiatan Pramuka di SMK Fatahillah merupakan ekstrakurikuler wajib yang bertujuan membentuk karakter kepemimpinan, kemandirian, dan rasa cinta tanah air. Setiap siswa aktif mengikuti latihan rutin setiap hari Jumat.',
                    'Berbagai kegiatan menarik kami selenggarakan seperti kemah bakti, penjelajahan alam, lomba Pramuka tingkat kota, dan penggalangan dana sosial. Prestasi kami telah diraih di berbagai ajang kepramukaan.',
                    'Melalui Gerakan Pramuka, siswa belajar bekerja sama dalam tim, memecahkan masalah, dan mengambil keputusan dengan cepat. Nilai-nilai Dasa Dharma dan Tri Satya menjadi pedoman dalam setiap kegiatan.',
                ],
                'documents' => [
                    ['original_name' => 'Program Kerja Pramuka 2025.pdf', 'mime_type' => 'application/pdf', 'size' => 256000],
                    ['original_name' => 'Laporan Kegiatan Kemah Bhakti.docx', 'mime_type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'size' => 512000],
                ],
            ],
            'kepalasekolah' => [
                'model' => KepalaSekolah::class,
                'folder' => 'kepala_sekolah',
                'name' => 'Profil Kepala Sekolah',
                'paragraphs' => [
                    'Kepala Sekolah SMK Fatahillah memiliki visi untuk menjadikan sekolah sebagai pusat unggulan pendidikan vokasi yang menghasilkan lulusan berdaya saing tinggi. Dengan pengalaman lebih dari 15 tahun di dunia pendidikan, beliau memimpin dengan penuh dedikasi dan integritas.',
                    'Program-program unggulan terus dikembangkan di bawah kepemimpinan beliau, termasuk penguatan kurikulum berbasis industri, peningkatan kualitas guru, serta pengembangan fasilitas sekolah yang modern dan representatif.',
                    'Kepala Sekolah juga aktif menjalin kemitraan dengan berbagai pihak, baik dari dunia usaha dan industri, perguruan tinggi, maupun pemerintah daerah, demi mewujudkan SMK Fatahillah yang bermutu dan berkarakter.',
                ],
                'documents' => [
                    ['original_name' => 'Visi Misi Kepala Sekolah.pdf', 'mime_type' => 'application/pdf', 'size' => 204800],
                    ['original_name' => 'Program Kerja Kepala Sekolah 2025.pdf', 'mime_type' => 'application/pdf', 'size' => 307200],
                ],
            ],
        ];

        $nullableImageModels = [
            Keislaman::class,
            HubunganIndustri::class,
            SaranaPrasarana::class,
            KepalaSekolah::class,
        ];

        foreach ($dummyContent as $key => $config) {
            $model = $config['model'];
            $paragraphs = $config['paragraphs'];
            $content = '<p>'.implode('</p><p>', $paragraphs).'</p>';

            $record = $model::firstOrCreate(
                ['name' => $config['name']],
                [
                    'name' => $config['name'],
                    'content' => $content,
                    'image' => in_array($config['model'], $nullableImageModels) ? null : '',
                    'profile_photo' => in_array($config['model'], $nullableImageModels) ? null : '',
                ]
            );

            $record->documents()->delete();

            foreach ($config['documents'] as $doc) {
                DivisionDocument::create([
                    'documentable_id' => $record->id,
                    'documentable_type' => $config['model'],
                    'folder' => $config['folder'],
                    'filename' => 'dummy_'.$doc['original_name'],
                    'original_name' => $doc['original_name'],
                    'mime_type' => $doc['mime_type'],
                    'size' => $doc['size'],
                ]);
            }
        }

        // ---------- SEED: JURUSAN ----------
        $jurusanList = ['Teknik Komputer dan Jaringan', 'Manajemen Perkantoran'];
        foreach ($jurusanList as $name) {
            Jurusan::firstOrCreate(['name' => $name]);
        }

        // ---------- SEED: TEKNIK KOMPUTER JARINGAN (TKJ) ----------
        TeknikKomputerJaringan::firstOrCreate(
            ['name' => 'Teknik Komputer dan Jaringan'],
            [
                'name' => 'Teknik Komputer dan Jaringan',
                'content' => '<p>TKJ adalah program keahlian yang mempelajari tentang perakitan komputer, jaringan dasar, dan administrasi server.</p>',
                'image' => '',
            ]
        );

        // ---------- SEED: OTKP ----------
        OTKP::firstOrCreate(
            ['name' => 'Manajemen Perkantoran'],
            [
                'name' => 'Manajemen Perkantoran',
                'content' => '<p>OTKP adalah program keahlian yang mempersiapkan siswa menjadi tenaga administrasi perkantoran yang profesional.</p>',
                'image' => '',
            ]
        );

        // ---------- SEED: PROFILE ----------
        Profile::firstOrCreate(
            ['name' => 'SMK Fatahillah Cileungsi'],
            [
                'name' => 'SMK Fatahillah Cileungsi',
                'content' => '<h2>Profil Sekolah</h2><p>SMK Fatahillah Cileungsi adalah sekolah menengah kejuruan yang berkomitmen mencetak lulusan berkarakter dan siap kerja.</p>',
                'image' => '',
                'map' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.123456!2d106.987654!3d-6.345678!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMjAnNDQuMiJTIDEwNsKwNTknMTUuNSJF!5e0!3m2!1sid!2sid!4v1234567890" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
                'no_telp' => '(021) 12345678',
                'instagram' => 'https://instagram.com/smkfatahillah',
                'facebook' => 'https://facebook.com/smkfatahillah',
                'youtube' => 'https://youtube.com/@smkfatahillah',
                'tiktok' => null,
                'twitter' => null,
                'izin_operasional' => '',
                'izin_pendirian' => '',
            ]
        );

        // ---------- SEED: FASILITAS ----------
        $fasilitasList = [
            ['title' => 'Laboratorium Komputer'],
            ['title' => 'Perpustakaan Digital'],
            ['title' => 'Bengkel Praktik'],
            ['title' => 'Ruang Kelas Ber-AC'],
            ['title' => 'Lapangan Olahraga'],
        ];
        foreach ($fasilitasList as $f) {
            Fasilitas::firstOrCreate(['title' => $f['title']], $f);
        }

        // ---------- SEED: SPMB ----------
        Spmb::firstOrCreate(
            ['title' => 'Informasi PPDB 2025'],
            [
                'title' => 'Informasi PPDB 2025',
                'content' => '<p>Pendaftaran Peserta Didik Baru Tahun Ajaran 2025/2026 telah dibuka. Segera daftarkan diri Anda.</p>',
                'image' => '',
                'file' => '',
                'link' => null,
            ]
        );

        // ---------- SEED: CATEGORIES ----------
        $catList = [
            ['name' => 'Akademik', 'slug' => 'akademik'],
            ['name' => 'Prestasi', 'slug' => 'prestasi'],
            ['name' => 'Kegiatan', 'slug' => 'kegiatan'],
        ];
        foreach ($catList as $c) {
            Category::firstOrCreate(['slug' => $c['slug']], $c);
        }

        // ---------- SEED: TAGS ----------
        $tagList = ['Olimpiade', 'PKL', 'Lomba'];
        foreach ($tagList as $name) {
            Tag::firstOrCreate(['slug' => Str::slug($name)], ['name' => $name, 'slug' => Str::slug($name)]);
        }

        // ---------- SEED: POSTS ----------
        $catAkademik = Category::where('slug', 'akademik')->first();
        $catPrestasi = Category::where('slug', 'prestasi')->first();
        $catKegiatan = Category::where('slug', 'kegiatan')->first();

        $postData = [
            ['title' => 'Kegiatan Belajar Mengajar Semester Genap 2025', 'category_id' => $catAkademik?->id ?? 1,
                'content' => '<p>Semester genap tahun ajaran 2025/2026 telah dimulai dengan berbagai program unggulan.</p>'],
            ['title' => 'Juara Umum Lomba Komputer Tingkat Kabupaten', 'category_id' => $catPrestasi?->id ?? 1,
                'content' => '<p>Selamat kepada siswa kami yang berhasil meraih juara umum kompetisi komputer tingkat kabupaten.</p>'],
            ['title' => 'Kunjungan Industri ke Perusahaan Teknologi', 'category_id' => $catKegiatan?->id ?? 1,
                'content' => '<p>Sebanyak 50 siswa mengikuti kunjungan industri ke perusahaan teknologi terkemuka.</p>'],
        ];
        foreach ($postData as $p) {
            Post::firstOrCreate(
                ['slug' => Str::slug($p['title'])],
                [
                    'title' => $p['title'],
                    'slug' => Str::slug($p['title']),
                    'content' => $p['content'],
                    'category_id' => $p['category_id'],
                    'image' => '',
                ]
            );
        }

        // ---------- SEED: EVENTS ----------
        $eventData = [
            ['title' => 'Pembagian Rapor Semester Genap', 'slug' => 'pembagian-rapor-genap',
                'content' => '<p>Pembagian rapor semester genap tahun ajaran 2025/2026.</p>',
                'location' => 'Aula SMK Fatahillah', 'date' => '2026-07-15'],
            ['title' => 'Praktik Kerja Lapangan (PKL) 2025', 'slug' => 'pkl-2025',
                'content' => '<p>Pelaksanaan PKL bagi siswa kelas XI di berbagai mitra industri.</p>',
                'location' => 'Mitra Industri', 'date' => '2026-08-01'],
            ['title' => 'Peringatan Hari Kemerdekaan', 'slug' => 'hari-kemerdekaan-2025',
                'content' => '<p>Upacara dan lomba dalam rangka HUT RI ke-81.</p>',
                'location' => 'Lapangan SMK Fatahillah', 'date' => '2026-08-17'],
        ];
        foreach ($eventData as $e) {
            Event::firstOrCreate(['slug' => $e['slug']], $e);
        }

        // ---------- SEED: SLIDERS ----------
        for ($i = 1; $i <= 3; $i++) {
            Slider::firstOrCreate(['image' => '']);
        }

        // ---------- SEED: PHOTOS ----------
        $photoCaptions = ['Kegiatan Belajar', 'Upacara Bendera', 'Praktik Komputer', 'Kunjungan Industri'];
        foreach ($photoCaptions as $cap) {
            Photo::firstOrCreate(['caption' => $cap], ['image' => '', 'caption' => $cap]);
        }

        // ---------- SEED: VIDEOS ----------
        Video::firstOrCreate(
            ['title' => 'Profil SMK Fatahillah'],
            ['title' => 'Profil SMK Fatahillah', 'embed' => 'https://www.youtube.com/embed/dQw4w9WgXcQ']
        );

        // ---------- SEED: KONTRIBUTOR ----------
        $jtkj = Jurusan::where('name', 'Teknik Komputer dan Jaringan')->first();
        $jotkp = Jurusan::where('name', 'Manajemen Perkantoran')->first();

        if ($jtkj) {
            Kontributor::firstOrCreate(
                ['title' => 'Praktik Jaringan TKJ 2025'],
                [
                    'title' => 'Praktik Jaringan TKJ 2025',
                    'slug' => Str::slug('Praktik Jaringan TKJ 2025'),
                    'content' => '<p>Siswa TKJ melaksanakan praktik jaringan komputer di laboratorium.</p>',
                    'jurusan_id' => $jtkj->id,
                    'image_1' => '',
                    'image_2' => '',
                    'image_3' => '',
                ]
            );
        }

        if ($jotkp) {
            Kontributor::firstOrCreate(
                ['title' => 'Administrasi Perkantoran OTKP'],
                [
                    'title' => 'Administrasi Perkantoran OTKP',
                    'slug' => Str::slug('Administrasi Perkantoran OTKP'),
                    'content' => '<p>Siswa OTKP mempelajari tata kelola administrasi perkantoran modern.</p>',
                    'jurusan_id' => $jotkp->id,
                    'image_1' => '',
                    'image_2' => '',
                    'image_3' => '',
                ]
            );
        }
    }
}
