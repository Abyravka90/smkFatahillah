<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $guardName = config('auth.defaults.guard', 'web');

        $divisions = [
            'kesiswaan',
            'keislaman',
            'hubunganindustri',
            'saranaprasarana',
            'kepalasekolah',
        ];

        $divisionsPlural = [
            'kurikulum' => ['kurikulum', 'kurikulums'],
            'pramuka' => ['pramuka', 'pramukas'],
        ];

        foreach ($divisions as $division) {
            foreach (['create', 'index', 'edit', 'delete'] as $action) {
                Permission::firstOrCreate([
                    'name' => "{$division}.{$action}",
                    'guard_name' => $guardName,
                ]);
            }
        }

        foreach ($divisionsPlural as $singular => $names) {
            foreach ($names as $name) {
                foreach (['create', 'index', 'edit', 'delete'] as $action) {
                    Permission::firstOrCreate([
                        'name' => "{$name}.{$action}",
                        'guard_name' => $guardName,
                    ]);
                }
            }
        }

        $roleSuperAdmin = Role::firstOrCreate(['name' => 'superadmin', 'guard_name' => $guardName]);
        $roleSuperAdmin->syncPermissions(Permission::all());

        $roleDivisions = [
            'admin_kesiswaan' => ['kesiswaan'],
            'admin_kurikulum' => ['kurikulum', 'kurikulums'],
            'admin_hubind' => ['hubunganindustri'],
            'admin_keislaman' => ['keislaman'],
            'admin_sarpras' => ['saranaprasarana'],
            'admin_pramuka' => ['pramuka', 'pramukas'],
            'admin_kepalasekolah' => ['kepalasekolah'],
        ];

        $roleUsers = [
            'superadmin' => [
                'name' => 'Super Admin',
                'email' => 'asep@gmail.com',
            ],
            'admin_kesiswaan' => [
                'name' => 'Admin Kesiswaan',
                'email' => 'kesiswaan@gmail.com',
            ],
            'admin_kurikulum' => [
                'name' => 'Admin Kurikulum',
                'email' => 'kurikulum@gmail.com',
            ],
            'admin_hubind' => [
                'name' => 'Admin Hubungan Industri',
                'email' => 'hubind@gmail.com',
            ],
            'admin_keislaman' => [
                'name' => 'Admin Keislaman',
                'email' => 'keislaman@gmail.com',
            ],
            'admin_sarpras' => [
                'name' => 'Admin Sarana dan Prasarana',
                'email' => 'saranaprasarana@gmail.com',
            ],
            'admin_pramuka' => [
                'name' => 'Admin Pramuka',
                'email' => 'pramuka@gmail.com',
            ],
            'admin_kepalasekolah' => [
                'name' => 'Admin Kepala Sekolah',
                'email' => 'kepalasekolah@gmail.com',
            ],
        ];

        foreach ($roleDivisions as $roleName => $permPrefixes) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => $guardName]);

            $permissions = collect($permPrefixes)->flatMap(function ($prefix) {
                return Permission::where('name', 'LIKE', "{$prefix}.%")->get();
            })->unique('id');

            $role->syncPermissions($permissions);
        }

        foreach ($roleUsers as $roleName => $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'password' => bcrypt('password'),
                ]
            );

            $user->assignRole($roleName);
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
