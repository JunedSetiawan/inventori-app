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
            'password' => Hash::make('superadminpass'),
            'role' => 'super-admin',
        ]);

        \App\Models\User::create([
            'name' => 'Manager',
            'email' => 'manager@gmail.com',
            'password' => Hash::make('managerpass'),
            'role' => 'manager',
        ]);

        \App\Models\User::create([
            'name' => 'Sales',
            'email' => 'sales@gmail.com',
            'password' => Hash::make('salespass'),
            'role' => 'sales',
        ]);

        \App\Models\User::create([
            'name' => 'Purchase',
            'email' => 'purchase@gmail.com',
            'password' => Hash::make('purchasepass'),
            'role' => 'purchase',
        ]);
    }
}
