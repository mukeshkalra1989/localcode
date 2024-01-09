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
            'name' => 'jake', 
            'email' => 'jake@mailinator.com',
            'password' => Hash::make('jake1234')
        ]);
        $superAdmin->assignRole('Super Admin');

        // Creating Admin User
        $admin = User::create([
            'name' => 'Cherry', 
            'email' => 'cheery@mailinator.com',
            'password' => Hash::make('cherry1234')
        ]);
        $admin->assignRole('Admin');

        // Creating Normal Manager User
        $normalManager = User::create([
            'name' => 'Mukesh', 
            'email' => 'mukesh@mailinator.com',
            'password' => Hash::make('mukesh1234')
        ]);
        $normalManager->assignRole('User');
    }
}
