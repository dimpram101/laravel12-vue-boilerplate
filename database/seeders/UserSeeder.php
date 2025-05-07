<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'super-admin@gmail.com',
            'password' => bcrypt('Minimal8'),
        ])->syncRoles([RoleEnum::SUPER_ADMIN->value]);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('Minimal8'),
        ])->syncRoles([RoleEnum::ADMIN->value]);

        User::create([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => bcrypt('123123123'),
        ])->syncRoles([RoleEnum::USER->value]);
    }
}
