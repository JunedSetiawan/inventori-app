<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'super-admin',
        ]);

        \App\Models\User::create([
            'name' => 'Manager',
            'email' => 'manager@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'manager',
        ]);

        \App\Models\User::create([
            'name' => 'Sales',
            'email' => 'sales@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'sales',
        ]);

        \App\Models\User::create([
            'name' => 'Sales 2',
            'email' => 'sales2@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'sales',
        ]);

        \App\Models\User::create([
            'name' => 'Purchase',
            'email' => 'purchase@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'purchase',
        ]);

        \App\Models\User::create([
            'name' => 'Purchase 2',
            'email' => 'purchase2@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'purchase',
        ]);
    }
}
