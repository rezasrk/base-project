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
                'name' => 'settings',
                'title' => 'Setting Menu',
                'family' => 'setting',
                'is_parent' => 1,
                'status' => 1,
                'guard_name' => 'sanctum',
            ],
            [
                'id' => 2,
                'name' => 'settings.role.store',
                'title' => 'Role Store',
                'family' => 'setting',
                'is_parent' => 1,
                'status' => 1,
                'guard_name' => 'sanctum',
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::query()->updateOrCreate(['id' => $permission['id']], $permission);
        }
    }
}
