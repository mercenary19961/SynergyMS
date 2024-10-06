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
                'gender' => 'male',
            ],
            [
                'name' => 'Client Tech',
                'email' => 'ctech@example.com',
                'password' => Hash::make('password'),
                'role' => 'Client',
                'gender' => 'female',
            ],
            [
                'name' => 'Manager Khaled',
                'email' => 'mkhaled@example.com',
                'password' => Hash::make('password'),
                'role' => 'Super Admin',
                'gender' => 'male',
            ],
            [
                'name' => 'HR Soundos',
                'email' => 'hrsoundos@example.com',
                'password' => Hash::make('password'),
                'role' => 'HR',
                'gender' => 'female',
            ],
            [
                'name' => 'Mohammad Jameel',
                'email' => 'mkhawara@example.com',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'gender' => 'male',
            ],
            [
                'name' => 'Noor Hamdan',
                'email' => 'noor.hamdan@example.com',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'gender' => 'female',
            ],
            [
                'name' => 'Ahmad Saeed',
                'email' => 'ahmad.saeed@example.com',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'gender' => 'male',
            ],
            [
                'name' => 'Omar Khaled',
                'email' => 'omar.khaled@example.com',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'gender' => 'male',
            ],
            [
                'name' => 'Sara Nassar',
                'email' => 'sara.nassar@example.com',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'gender' => 'female',
            ],
            [
                'name' => 'Mona Hasan',
                'email' => 'mona.hasan@example.com',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'gender' => 'female',
            ],
            [
                'name' => 'Ahmad Qasem',
                'email' => 'ahmadqasem@example.com',
                'password' => Hash::make('password'),
                'role' => 'Project Manager',
                'gender' => 'male',
            ],
            [
                'name' => 'Sara Ali',
                'email' => 'saraali@example.com',
                'password' => Hash::make('password'),
                'role' => 'Project Manager',
                'gender' => 'female',
            ],
            [
                'name' => 'Khaled Yaseen',
                'email' => 'khaledyaseen@example.com',
                'password' => Hash::make('password'),
                'role' => 'Project Manager',
                'gender' => 'male',
            ],
            [
                'name' => 'Omar Farouk',
                'email' => 'omarfarouk@example.com',
                'password' => Hash::make('password'),
                'role' => 'Project Manager',
                'gender' => 'male',
            ],
            [
                'name' => 'Lina Samara',
                'email' => 'linasamara@example.com',
                'password' => Hash::make('password'),
                'role' => 'Project Manager',
                'gender' => 'female',
            ],
            [
                'name' => 'Client Media',
                'email' => 'cmedia@example.com',
                'password' => Hash::make('password'),
                'role' => 'Client',
                'gender' => 'female',
            ],
            [
                'name' => 'Client Healthcare',
                'email' => 'chealthcare@example.com',
                'password' => Hash::make('password'),
                'role' => 'Client',
                'gender' => 'female',
            ],
            [
                'name' => 'Client Finance',
                'email' => 'cfinance@example.com',
                'password' => Hash::make('password'),
                'role' => 'Client',
                'gender' => 'male',
            ],
            [
                'name' => 'Client Energy',
                'email' => 'cenergy@example.com',
                'password' => Hash::make('password'),
                'role' => 'Client',
                'gender' => 'male',
            ],
            [
                'name' => 'Client EduSmart',
                'email' => 'cedusmart@example.com',
                'password' => Hash::make('password'),
                'role' => 'Client',
                'gender' => 'female',
            ],
            [
                'name' => 'HR Mahmoud',
                'email' => 'hrmahmoud@example.com',
                'password' => Hash::make('password'),
                'role' => 'HR',
                'gender' => 'male',
            ],
            [
                'name' => 'HR Abeer',
                'email' => 'hrabeer@example.com',
                'password' => Hash::make('password'),
                'role' => 'HR',
                'gender' => 'female',
            ],
            [
                'name' => 'HR Rania',
                'email' => 'hrrania@example.com',
                'password' => Hash::make('password'),
                'role' => 'HR',
                'gender' => 'female',
            ],
            [
                'name' => 'HR Omar',
                'email' => 'hromar@example.com',
                'password' => Hash::make('password'),
                'role' => 'HR',
                'gender' => 'male',
            ],
        ];

        foreach ($users as $index => $userData) {
            $user = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => $userData['password'],
                'gender' => $userData['gender'],  // Save gender data
            ]);

            // Assign role to user
            $user->assignRole($userData['role']);

            if ($index >= 4 && $index <= 9) {
                $imagePath = 'employee_images/employee_' . ($index + 1) . '.jpg';
                $user->image = $imagePath;
                $user->save();
            }
        }
    }
}
