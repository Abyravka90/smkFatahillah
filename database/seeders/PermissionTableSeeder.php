<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $guardName = config('auth.defaults.guard', 'web');

        $permissions = [
            // posts
            'posts.create',
            'posts.index',
            'posts.edit',
            'posts.delete',

            // tags
            'tags.create',
            'tags.index',
            'tags.edit',
            'tags.delete',

            // categories
            'categories.create',
            'categories.index',
            'categories.edit',
            'categories.delete',

            // events
            'events.create',
            'events.index',
            'events.edit',
            'events.delete',

            // photos
            'photos.create',
            'photos.index',
            'photos.delete',

            // videos
            'videos.create',
            'videos.index',
            'videos.edit',
            'videos.delete',

            // sliders
            'sliders.create',
            'sliders.index',
            'sliders.delete',

            // roles
            'roles.create',
            'roles.index',
            'roles.edit',
            'roles.delete',

            // permissions
            'permissions.index',
            'permissions.create',

            // users
            'users.create',
            'users.index',
            'users.edit',
            'users.delete',
        ];

        foreach ($permissions as $name) {
            Permission::firstOrCreate(
                ['name' => $name, 'guard_name' => $guardName],
                ['name' => $name, 'guard_name' => $guardName]
            );
        }
    }
}
