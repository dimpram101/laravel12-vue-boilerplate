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
        ]);
        Role::create([
            'name' => RoleEnum::ADMIN->value,
            'guard_name' => 'web',
        ]);
        Role::create([
            'name' => RoleEnum::USER->value,
            'guard_name' => 'web',
        ]);
        Role::create([
            'name' => RoleEnum::KAPRODI->value,
            'guard_name' => 'web',
        ]);
        Role::create([
            'name' => RoleEnum::DOSEN->value,
            'guard_name' => 'web',
        ]);
    }
}
