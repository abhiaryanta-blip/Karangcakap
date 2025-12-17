<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin',
            'email' => 'admin@karangcakap.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create Regular Users
        $users = [
            [
                'name' => 'Abhi',
                'email' => 'abhi@karangcakap.com',
                'password' => Hash::make('abhi123'),
                'role' => 'user',
            ],
            [
                'name' => 'Dita',
                'email' => 'dita@karangcakap.com',
                'password' => Hash::make('dita123'),
                'role' => 'user',
            ],
            [
                'name' => 'Wibhu',
                'email' => 'wibhu@karangcakap.com',
                'password' => Hash::make('wibhu123'),
                'role' => 'user',
            ],
            [
                'name' => 'Purnama',
                'email' => 'purnama@karangcakap.com',
                'password' => Hash::make('purnama123'),
                'role' => 'user',
            ],
            [
                'name' => 'Sugiri',
                'email' => 'sugiri@karangcakap.com',
                'password' => Hash::make('sugiri123'),
                'role' => 'user',
            ],
        ];

        foreach ($users as $userData) {
            User::create(array_merge($userData, [
                'email_verified_at' => now(),
            ]));
        }
    }
}




