<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'password' => Hash::make('password'),
                'role' => 'Super Admin',
            ],
            [
                'name' => 'Client Tech',
                'email' => 'ctech@example.com',
                'password' => Hash::make('password'),
                'role' => 'Client',
            ],
            [
                'name' => 'Manager Khaled',
                'email' => 'mkhaled@example.com',
                'password' => Hash::make('password'),
                'role' => 'Super Admin',
            ],
            [
                'name' => 'HR soundos',
                'email' => 'hrsoundos@example.com',
                'password' => Hash::make('password'),
                'role' => 'HR',
            ],
            [
                'name' => 'Mohammad Khawara',
                'email' => 'mkhawara@example.com',
                'password' => Hash::make('password'),
                'role' => 'Super Admin',
            ],
            [
                'name' => 'Noor Hamdan',
                'email' => 'noor.hamdan@example.com',
                'password' => Hash::make('password'),
                'role' => 'Super Admin',
            ],
            [
                'name' => 'Ahmad Saeed',
                'email' => 'ahmad.saeed@example.com',
                'password' => Hash::make('password'),
                'role' => 'Super Admin',
            ],
            [
                'name' => 'Omar Khaled',
                'email' => 'omar.khaled@example.com',
                'password' => Hash::make('password'),
                'role' => 'Super Admin',
            ],
            [
                'name' => 'Sara Nassar',
                'email' => 'sara.nassar@example.com',
                'password' => Hash::make('password'),
                'role' => 'Super Admin',
            ],
            [
                'name' => 'Mona Hasan',
                'email' => 'mona.hasan@example.com',
                'password' => Hash::make('password'),
                'role' => 'Super Admin',
            ],
            [
                'name' => 'Ahmad Qasem',
                'email' => 'ahmadqasem@example.com',
                'password' => Hash::make('password'),
                'role' => 'Super Admin',
            ],
            [
                'name' => 'Sara Ali',
                'email' => 'saraali@example.com',
                'password' => Hash::make('password'),
                'role' => 'Super Admin',
            ],
            [
                'name' => 'Khaled Yaseen',
                'email' => 'khaledyaseen@example.com',
                'password' => Hash::make('password'),
                'role' => 'Super Admin',
            ],
            [
                'name' => 'Omar Farouk',
                'email' => 'omarfarouk@example.com',
                'password' => Hash::make('password'),
                'role' => 'Super Admin',
            ],
            [
                'name' => 'Lina Samara',
                'email' => 'linasamara@example.com',
                'password' => Hash::make('password'),
                'role' => 'Super Admin',
            ],
            [
                'name' => 'Client Media',
                'email' => 'cmedia@example.com',
                'password' => Hash::make('password'),
                'role' => 'Client',
            ],
            [
                'name' => 'Client Healthcare',
                'email' => 'chealthcare@example.com',
                'password' => Hash::make('password'),
                'role' => 'Client',
            ],
            [
                'name' => 'Client Finance',
                'email' => 'cfinance@example.com',
                'password' => Hash::make('password'),
                'role' => 'Client',
            ],
            [
                'name' => 'Client Energy',
                'email' => 'cenergy@example.com',
                'password' => Hash::make('password'),
                'role' => 'Client',
            ],
            [
                'name' => 'Client EduSmart',
                'email' => 'cedusmart@example.com',
                'password' => Hash::make('password'),
                'role' => 'Client',
            ],
            [
                'name' => 'HR Mahmoud',
                'email' => 'hrmahmoud@example.com',
                'password' => Hash::make('password'),
                'role' => 'HR',
            ],
            [
                'name' => 'HR Abeer',
                'email' => 'hrabeer@example.com',
                'password' => Hash::make('password'),
                'role' => 'HR',
            ],
            [
                'name' => 'HR Rania',
                'email' => 'hrrania@example.com',
                'password' => Hash::make('password'),
                'role' => 'HR',
            ],
            [
                'name' => 'HR Omar',
                'email' => 'hromar@example.com',
                'password' => Hash::make('password'),
                'role' => 'HR',
            ],
        ];

        foreach ($users as $userData) {
            $user = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => $userData['password'],
            ]);

            // Assign role to user
            $user->assignRole($userData['role']);
        }
    }
}
