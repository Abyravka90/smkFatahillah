<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $userCreate = User::create([
            'name' => 'Asep Cahya Nugraha',
            'email' => 'asep@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $role = Role::find(1);
        $permissions = Permission::all();

        $role->syncPermissions($permissions);

        $user = User::find(1);
        $user->assignRole($role->name);

    }
}
