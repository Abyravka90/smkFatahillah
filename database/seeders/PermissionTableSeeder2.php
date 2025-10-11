<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder2 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //otkp
        Permission::create(['name' => 'o_t_k_p_s.create']);
        Permission::create(['name' => 'o_t_k_p_s.index']);
        Permission::create(['name' => 'o_t_k_p_s.edit']);
        Permission::create(['name' => 'o_t_k_p_s.delete']);
        
        //kesiswaan
        Permission::create(['name' => 'kesiswaan.create']);
        Permission::create(['name' => 'kesiswaan.index']);
        Permission::create(['name' => 'kesiswaan.edit']);
        Permission::create(['name' => 'kesiswaan.delete']);
        
        //kurikulum
        Permission::create(['name' => 'kurikulums.create']);
        Permission::create(['name' => 'kurikulums.index']);
        Permission::create(['name' => 'kurikulums.edit']);
        Permission::create(['name' => 'kurikulums.delete']);
        
        //pramuka
        Permission::create(['name' => 'pramukas.create']);
        Permission::create(['name' => 'pramukas.index']);
        Permission::create(['name' => 'pramukas.edit']);
        Permission::create(['name' => 'pramukas.delete']);

        //Teknik Kendaraan Ringan
        Permission::create(['name' => 'TeknikKendaraanRingan.create']);
        Permission::create(['name' => 'TeknikKendaraanRingan.index']);
        Permission::create(['name' => 'TeknikKendaraanRingan.edit']);
        Permission::create(['name' => 'TeknikKendaraanRingan.delete']);

        //Teknik Komputer Jaringan
        Permission::create(['name' => 'TeknikKomputerJaringan.create']);
        Permission::create(['name' => 'TeknikKomputerJaringan.index']);
        Permission::create(['name' => 'TeknikKomputerJaringan.edit']);
        Permission::create(['name' => 'TeknikKomputerJaringan.delete']);

        //Teknik Komputer Jaringan
        Permission::create(['name' => 'TeknikPemesinan.create']);
        Permission::create(['name' => 'TeknikPemesinan.index']);
        Permission::create(['name' => 'TeknikPemesinan.edit']);
        Permission::create(['name' => 'TeknikPemesinan.delete']);


    }
}
