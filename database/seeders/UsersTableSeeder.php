<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Admin
        User::create([
            'name' => 'Alice Admin',
            'email' => 'admin@safezone.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Regular Users
        $users = [
            ['name' => 'John Doe', 'email' => 'john.doe@safezone.com'],
            ['name' => 'Jane Smith', 'email' => 'jane.smith@safezone.com'],
            ['name' => 'Bob Johnson', 'email' => 'bob.johnson@safezone.com'],
        ];
        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make('password123'),
                'role' => 'user',
            ]);
        }

        // Agents
        for ($i = 1; $i <= 6; $i++) {
            User::create([
                'name' => "Agent $i",
                'email' => "agent$i@safezone.com",
                'password' => Hash::make('password123'),
                'role' => 'agent',
            ]);
        }

        // Medical Staff
        for ($i = 1; $i <= 6; $i++) {
            User::create([
                'name' => "Dr. Med$i",
                'email' => "med$i@safezone.com",
                'password' => Hash::make('password123'),
                'role' => 'medical',
            ]);
        }
    }
}
