<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creating Super Admin User
        $superAdmin = User::create([
            'name' => 'Super admin', 
            'email' => 'superadmin@mailinator.com',
            'password' => Hash::make('12345678')
        ]);
        $superAdmin->assignRole('Super Admin');

        // Creating Admin User
        $admin = User::create([
            'name' => 'Admin', 
            'email' => 'admin@mailinator.com',
            'password' => Hash::make('12345678')
        ]);
        $admin->assignRole('Admin');

        // Creating Normal Manager User
        $normalManager = User::create([
            'name' => 'Mukesh', 
            'email' => 'mukesh@mailinator.com',
            'password' => Hash::make('12345678')
        ]);
        $normalManager->assignRole('User');
    }
}
