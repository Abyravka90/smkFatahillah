<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $guardName = config('auth.defaults.guard', 'web');
        Role::firstOrCreate(
            ['name' => 'admin', 'guard_name' => $guardName],
            ['name' => 'admin', 'guard_name' => $guardName]
        );
    }
}
