<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder2 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $guardName = config('auth.defaults.guard', 'web');

        // Keep legacy permission names (already used in some places) and add
        // normalized names that match the routes/controllers in this project.
        $permissions = [
            // OTKP (legacy + normalized)
            'o_t_k_p_s.create',
            'o_t_k_p_s.index',
            'o_t_k_p_s.edit',
            'o_t_k_p_s.delete',
            'otkp.create',
            'otkp.index',
            'otkp.edit',
            'otkp.delete',

            // TKJ (legacy + normalized)
            'TeknikKomputerJaringan.create',
            'TeknikKomputerJaringan.index',
            'TeknikKomputerJaringan.edit',
            'TeknikKomputerJaringan.delete',
            'tkj.create',
            'tkj.index',
            'tkj.edit',
            'tkj.delete',

            // kesiswaan (already normalized)
            'kesiswaan.create',
            'kesiswaan.index',
            'kesiswaan.edit',
            'kesiswaan.delete',

            // kurikulum (legacy plural + normalized)
            'kurikulums.create',
            'kurikulums.index',
            'kurikulums.edit',
            'kurikulums.delete',
            'kurikulum.create',
            'kurikulum.index',
            'kurikulum.edit',
            'kurikulum.delete',

            // pramuka (legacy plural + normalized)
            'pramukas.create',
            'pramukas.index',
            'pramukas.edit',
            'pramukas.delete',
            'pramuka.create',
            'pramuka.index',
            'pramuka.edit',
            'pramuka.delete',

            // Other majors (legacy names kept)
            'TeknikKendaraanRingan.create',
            'TeknikKendaraanRingan.index',
            'TeknikKendaraanRingan.edit',
            'TeknikKendaraanRingan.delete',
            'TeknikPemesinan.create',
            'TeknikPemesinan.index',
            'TeknikPemesinan.edit',
            'TeknikPemesinan.delete',

            // Keislaman
            'keislaman.create',
            'keislaman.index',
            'keislaman.edit',
            'keislaman.delete',

            // Hubungan Industri
            'hubunganindustri.create',
            'hubunganindustri.index',
            'hubunganindustri.edit',
            'hubunganindustri.delete',

            // Sarana & Prasarana
            'saranaprasarana.create',
            'saranaprasarana.index',
            'saranaprasarana.edit',
            'saranaprasarana.delete',
        ];

        foreach ($permissions as $name) {
            Permission::firstOrCreate(
                ['name' => $name, 'guard_name' => $guardName],
                ['name' => $name, 'guard_name' => $guardName]
            );
        }

    }
}
