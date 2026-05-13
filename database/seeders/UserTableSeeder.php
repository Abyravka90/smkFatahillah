<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

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

        $guardName = config('auth.defaults.guard', 'web');
        $role = Role::firstOrCreate(
            ['name' => 'admin', 'guard_name' => $guardName],
            ['name' => 'admin', 'guard_name' => $guardName]
        );
        $permissions = Permission::where('guard_name', $guardName)->get();

        $role->syncPermissions($permissions);

        $user = User::findOrFail($userCreate->id);
        $user->assignRole($role->name);
        app(PermissionRegistrar::class)->forgetCachedPermissions();

    }
}
