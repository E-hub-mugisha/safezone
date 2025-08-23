<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'Eric Mugisha',
                'email' => 'eric@example.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Alice Uwimana',
                'email' => 'alice@example.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'John Niyonzima',
                'email' => 'john@example.com',
                'password' => Hash::make('password123'),
                'role' => 'agent',
            ],
            [
                'name' => 'Claire Mukamana',
                'email' => 'claire@example.com',
                'password' => Hash::make('password123'),
                'role' => 'agent',
            ],
            [
                'name' => 'Dr. Patrick Habimana',
                'email' => 'patrick@example.com',
                'password' => Hash::make('password123'),
                'role' => 'medical',
            ],
            [
                'name' => 'Dr. Jeanne Mukeshimana',
                'email' => 'jeanne@example.com',
                'password' => Hash::make('password123'),
                'role' => 'medical',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
