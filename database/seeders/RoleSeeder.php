<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => RoleEnum::SUPER_ADMIN->value,
            'guard_name' => 'web',
        ])->givePermissionTo([
            'create user',
            'delete user',
            'update user',
            'create role',
            'delete role',
            'update role',
            'create permission',
            'delete permission',
            'update permission',
        ]);
        Role::create([
            'name' => RoleEnum::ADMIN->value,
            'guard_name' => 'web',
        ])->givePermissionTo([
            'create user',
            'delete user',
            'update user',
            'create role',
            'delete role',
            'update role',
        ]);
        Role::create([
            'name' => RoleEnum::USER->value,
            'guard_name' => 'web',
        ]);
    }
}
