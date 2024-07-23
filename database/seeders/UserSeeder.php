<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        //Admin user
        User::create([
           'title' => 'Mr',
           'firstName' => 'Admin',
            'lastName' => 'User',
            'position' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // Change this to a secure password
            'phone_number' => '1234567890',
        //    //'disable' => false,
        //     //'desactivate_date' => null,
            'is_superadmin' => true,
            'role' => 'admin',
         ]);

        // // Regular user
        // User::create([
        //     'title' => 'Ms',
        //     'firstName' => 'Regular',
        //     'lastName' => 'User',
        //     'position' => 'User',
        //     'email' => 'user@example.com',
        //     'password' => Hash::make('password'), // Change this to a secure password
        //     'phone_number' => '0987654321',
        //     //'disable' => false,
        //     //'desactivate_date' => null,
        //     //'is_superadmin' => false,
        //     //'role' => 'user',
        // ]);

        // Créer 50 utilisateurs réguliers
        User::factory(50)->create();

        // Créer 1 administrateur
        // User::factory()->admin()->create();
   
    }
}
