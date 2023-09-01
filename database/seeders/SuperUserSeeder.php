<?php

namespace Database\Seeders;

use App\Enum\UserEnum;
use App\Models\Permission;
use App\Models\Project;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperUserSeeder extends Seeder
{
    public function run(): void
    {
        $role = Role::query()->updateOrCreate(['id' => 1], [
            'id' => 1,
            'name' => 'programmer',
            'guard_name' => 'sanctum',
            'status' => 0,
        ]);

        $user = User::query()->updateOrCreate([
            'id' => UserEnum::SUPER_USER->value,
        ], [
            'username' => config('azaran.super_user.username'),
            'name' => 'R',
            'family' => 'S',
            'email' => config('azaran.super_user.email'),
            'password' => Hash::make(config('azaran.super_user.password')),
            'personality' => UserEnum::PANEL->value,
        ]);
        $projectIds = Project::query()->get()->pluck('id')->toArray();
        $permissions = Permission::query()->get()->pluck('id')->toArray();


        $user->projects()->sync($projectIds);
        $user->roles()->sync([1]);
        $role->permissions()->sync($permissions);
    }
}
