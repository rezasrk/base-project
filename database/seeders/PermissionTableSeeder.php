<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [
                'id' => 1,
                'name' => 'settings.menu',
                'status' => 1,
                'parent_id' => 0,
                'guard_name' => 'sanctum',
            ],
            [
                'id' => 2,
                'name' => 'settings.roles.store',
                'parent_id' => 1,
                'status' => 1,
                'guard_name' => 'sanctum',
            ],
            [
                'id' => 3,
                'name' => 'settings.roles.index',
                'parent_id' => 1,
                'status' => 1,
                'guard_name' => 'sanctum',
            ],
            [
                'id' => 4,
                'name' => 'settings.roles.update',
                'parent_id' => 1,
                'status' => 1,
                'guard_name' => 'sanctum',
            ],
            [
                'id' => 5,
                'name' => 'settings.projects.store',
                'parent_id' => 1,
                'status' => 1,
                'guard_name' => 'sanctum',
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::query()->updateOrCreate(['id' => $permission['id']], $permission);
        }
    }
}
