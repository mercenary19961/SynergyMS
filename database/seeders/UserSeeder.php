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
                'gender' => 'Male',
            ],
            [
                'name' => 'Client Tech',
                'email' => 'ctech@example.com',
                'password' => Hash::make('password'),
                'role' => 'Client',
                'gender' => 'Female',
            ],
            [
                'name' => 'Manager Khaled',
                'email' => 'mkhaled@example.com',
                'password' => Hash::make('password'),
                'role' => 'Super Admin',
                'gender' => 'Male',
            ],
            [
                'name' => 'HR Soundos',
                'email' => 'hrsoundos@example.com',
                'password' => Hash::make('password'),
                'role' => 'HR',
                'gender' => 'Female',
            ],
            [
                'name' => 'Mohammad Jameel',
                'email' => 'mkhawara@example.com',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'gender' => 'Male',
            ],
            [
                'name' => 'Noor Hamdan',
                'email' => 'noor.hamdan@example.com',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'gender' => 'Female',
            ],
            [
                'name' => 'Ahmad Saeed',
                'email' => 'ahmad.saeed@example.com',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'gender' => 'Male',
            ],
            [
                'name' => 'Omar Khaled',
                'email' => 'omar.khaled@example.com',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'gender' => 'Male',
            ],
            [
                'name' => 'Sara Nassar',
                'email' => 'sara.nassar@example.com',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'gender' => 'Female',
            ],
            [
                'name' => 'Mona Hasan',
                'email' => 'mona.hasan@example.com',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'gender' => 'Female',
            ],
            [
                'name' => 'Ahmad Qasem',
                'email' => 'ahmadqasem@example.com',
                'password' => Hash::make('password'),
                'role' => 'Project Manager',
                'gender' => 'Male',
            ],
            [
                'name' => 'Sara Ali',
                'email' => 'saraali@example.com',
                'password' => Hash::make('password'),
                'role' => 'Project Manager',
                'gender' => 'Female',
            ],
            [
                'name' => 'Khaled Yaseen',
                'email' => 'khaledyaseen@example.com',
                'password' => Hash::make('password'),
                'role' => 'Project Manager',
                'gender' => 'Male',
            ],
            [
                'name' => 'Omar Farouk',
                'email' => 'omarfarouk@example.com',
                'password' => Hash::make('password'),
                'role' => 'Project Manager',
                'gender' => 'Male',
            ],
            [
                'name' => 'Lina Samara',
                'email' => 'linasamara@example.com',
                'password' => Hash::make('password'),
                'role' => 'Project Manager',
                'gender' => 'Female',
            ],
            [
                'name' => 'Client Media',
                'email' => 'cmedia@example.com',
                'password' => Hash::make('password'),
                'role' => 'Client',
                'gender' => 'Female',
            ],
            [
                'name' => 'Client Healthcare',
                'email' => 'chealthcare@example.com',
                'password' => Hash::make('password'),
                'role' => 'Client',
                'gender' => 'Female',
            ],
            [
                'name' => 'Client Finance',
                'email' => 'cfinance@example.com',
                'password' => Hash::make('password'),
                'role' => 'Client',
                'gender' => 'Male',
            ],
            [
                'name' => 'Client Energy',
                'email' => 'cenergy@example.com',
                'password' => Hash::make('password'),
                'role' => 'Client',
                'gender' => 'Male',
            ],
            [
                'name' => 'Client EduSmart',
                'email' => 'cedusmart@example.com',
                'password' => Hash::make('password'),
                'role' => 'Client',
                'gender' => 'Female',
            ],
            [
                'name' => 'HR Mahmoud',
                'email' => 'hrmahmoud@example.com',
                'password' => Hash::make('password'),
                'role' => 'HR',
                'gender' => 'Male',
            ],
            [
                'name' => 'HR Abeer',
                'email' => 'hrabeer@example.com',
                'password' => Hash::make('password'),
                'role' => 'HR',
                'gender' => 'Female',
            ],
            [
                'name' => 'HR Rania',
                'email' => 'hrrania@example.com',
                'password' => Hash::make('password'),
                'role' => 'HR',
                'gender' => 'Female',
            ],
            [
                'name' => 'HR Omar',
                'email' => 'hromar@example.com',
                'password' => Hash::make('password'),
                'role' => 'HR',
                'gender' => 'Male',
            ],
        ];

        foreach ($users as $index => $userData) {
            $user = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => $userData['password'],
                'gender' => $userData['gender'],
            ]);

            $user->assignRole($userData['role']);
        }
    }
}
