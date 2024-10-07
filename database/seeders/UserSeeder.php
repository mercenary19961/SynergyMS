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
            // Existing Users
            // ID: 1
            ['name' => 'Super Admin', 'email' => 'superadmin@example.com', 'password' => Hash::make('password'), 'role' => 'Super Admin', 'gender' => 'Male'],
            // ID: 2
            ['name' => 'Client Tech', 'email' => 'ctech@example.com', 'password' => Hash::make('password'), 'role' => 'Client', 'gender' => 'Female'],
            // ID: 3
            ['name' => 'Manager Khaled', 'email' => 'mkhaled@example.com', 'password' => Hash::make('password'), 'role' => 'Super Admin', 'gender' => 'Male'],
            // ID: 4
            ['name' => 'HR Soundos', 'email' => 'hrsoundos@example.com', 'password' => Hash::make('password'), 'role' => 'HR', 'gender' => 'Female'],
            // ID: 5
            ['name' => 'Mohammad Jameel', 'email' => 'mkhawara@example.com', 'password' => Hash::make('password'), 'role' => 'Employee', 'gender' => 'Male'],
            // ID: 6
            ['name' => 'Noor Hamdan', 'email' => 'noor.hamdan@example.com', 'password' => Hash::make('password'), 'role' => 'Employee', 'gender' => 'Female'],
            // ID: 7
            ['name' => 'Ahmad Saeed', 'email' => 'ahmad.saeed@example.com', 'password' => Hash::make('password'), 'role' => 'Employee', 'gender' => 'Male'],
            // ID: 8
            ['name' => 'Omar Khaled', 'email' => 'omar.khaled@example.com', 'password' => Hash::make('password'), 'role' => 'Employee', 'gender' => 'Male'],
            // ID: 9
            ['name' => 'Sara Nassar', 'email' => 'sara.nassar@example.com', 'password' => Hash::make('password'), 'role' => 'Employee', 'gender' => 'Female'],
            // ID: 10
            ['name' => 'Mona Hasan', 'email' => 'mona.hasan@example.com', 'password' => Hash::make('password'), 'role' => 'Employee', 'gender' => 'Female'],
            // ID: 11
            ['name' => 'Ahmad Qasem', 'email' => 'ahmadqasem@example.com', 'password' => Hash::make('password'), 'role' => 'Project Manager', 'gender' => 'Male'],
            // ID: 12
            ['name' => 'Sara Ali', 'email' => 'saraali@example.com', 'password' => Hash::make('password'), 'role' => 'Project Manager', 'gender' => 'Female'],
            // ID: 13
            ['name' => 'Khaled Yaseen', 'email' => 'khaledyaseen@example.com', 'password' => Hash::make('password'), 'role' => 'Project Manager', 'gender' => 'Male'],
            // ID: 14
            ['name' => 'Omar Farouk', 'email' => 'omarfarouk@example.com', 'password' => Hash::make('password'), 'role' => 'Project Manager', 'gender' => 'Male'],
            // ID: 15
            ['name' => 'Lina Samara', 'email' => 'linasamara@example.com', 'password' => Hash::make('password'), 'role' => 'Project Manager', 'gender' => 'Female'],
            // ID: 16
            ['name' => 'Client Media', 'email' => 'cmedia@example.com', 'password' => Hash::make('password'), 'role' => 'Client', 'gender' => 'Female'],
            // ID: 17
            ['name' => 'Client Healthcare', 'email' => 'chealthcare@example.com', 'password' => Hash::make('password'), 'role' => 'Client', 'gender' => 'Female'],
            // ID: 18
            ['name' => 'Client Finance', 'email' => 'cfinance@example.com', 'password' => Hash::make('password'), 'role' => 'Client', 'gender' => 'Male'],
            // ID: 19
            ['name' => 'Client Energy', 'email' => 'cenergy@example.com', 'password' => Hash::make('password'), 'role' => 'Client', 'gender' => 'Male'],
            // ID: 20
            ['name' => 'Client EduSmart', 'email' => 'cedusmart@example.com', 'password' => Hash::make('password'), 'role' => 'Client', 'gender' => 'Female'],
            // ID: 21
            ['name' => 'HR Mahmoud', 'email' => 'hrmahmoud@example.com', 'password' => Hash::make('password'), 'role' => 'HR', 'gender' => 'Male'],
            // ID: 22
            ['name' => 'HR Abeer', 'email' => 'hrabeer@example.com', 'password' => Hash::make('password'), 'role' => 'HR', 'gender' => 'Female'],
            // ID: 23
            ['name' => 'HR Rania', 'email' => 'hrrania@example.com', 'password' => Hash::make('password'), 'role' => 'HR', 'gender' => 'Female'],
            // ID: 24
            ['name' => 'HR Omar', 'email' => 'hromar@example.com', 'password' => Hash::make('password'), 'role' => 'HR', 'gender' => 'Male'],

            // Newly Added Users (Employees)
            // ID: 25
            ['name' => 'Layla Fathi', 'email' => 'layla.fathi@example.com', 'password' => Hash::make('password'), 'role' => 'Employee', 'gender' => 'Female'],
            // ID: 26
            ['name' => 'Abdelrahman Ali', 'email' => 'abdelrahman.ali@example.com', 'password' => Hash::make('password'), 'role' => 'Employee', 'gender' => 'Male'],
            // ID: 27
            ['name' => 'Hana Rami', 'email' => 'hana.rami@example.com', 'password' => Hash::make('password'), 'role' => 'Employee', 'gender' => 'Female'],
            // ID: 28
            ['name' => 'Tarek Abdul', 'email' => 'tarek.abdul@example.com', 'password' => Hash::make('password'), 'role' => 'Employee', 'gender' => 'Male'],
            // ID: 29
            ['name' => 'Malak Saleh', 'email' => 'malak.saleh@example.com', 'password' => Hash::make('password'), 'role' => 'Employee', 'gender' => 'Female'],
            // ID: 30
            ['name' => 'Khalil Mohammed', 'email' => 'khalil.mohammed@example.com', 'password' => Hash::make('password'), 'role' => 'Employee', 'gender' => 'Male'],
            // ID: 31
            ['name' => 'Samir Nabil', 'email' => 'samir.nabil@example.com', 'password' => Hash::make('password'), 'role' => 'Employee', 'gender' => 'Male'],
            // ID: 32
            ['name' => 'Lina Omar', 'email' => 'lina.omar@example.com', 'password' => Hash::make('password'), 'role' => 'Employee', 'gender' => 'Female'],
            // ID: 33
            ['name' => 'Marwan Taha', 'email' => 'marwan.taha@example.com', 'password' => Hash::make('password'), 'role' => 'Employee', 'gender' => 'Male'],
            // ID: 34
            ['name' => 'Abeer Yassin', 'email' => 'abeer.yassin@example.com', 'password' => Hash::make('password'), 'role' => 'Employee', 'gender' => 'Female'],
            // ID: 35
            ['name' => 'Rania Mansour', 'email' => 'rania.mansour@example.com', 'password' => Hash::make('password'), 'role' => 'Employee', 'gender' => 'Female'],
            // ID: 36
            ['name' => 'Youssef Khaled', 'email' => 'youssef.khaled@example.com', 'password' => Hash::make('password'), 'role' => 'Employee', 'gender' => 'Male'],
            // ID: 37
            ['name' => 'Fatima Zayed', 'email' => 'fatima.zayed@example.com', 'password' => Hash::make('password'), 'role' => 'Employee', 'gender' => 'Female'],
            // ID: 38
            ['name' => 'Mariam Faris', 'email' => 'mariam.faris@example.com', 'password' => Hash::make('password'), 'role' => 'Employee', 'gender' => 'Female'],
            // ID: 39
            ['name' => 'Ali Hassan', 'email' => 'ali.hassan@example.com', 'password' => Hash::make('password'), 'role' => 'Employee', 'gender' => 'Male'],
            // ID: 40
            ['name' => 'Ahmed Mahmoud', 'email' => 'ahmed.mahmoud@example.com', 'password' => Hash::make('password'), 'role' => 'Employee', 'gender' => 'Male'],
            // ID: 41
            ['name' => 'Maysa Tarek', 'email' => 'maysa.tarek@example.com', 'password' => Hash::make('password'), 'role' => 'Employee', 'gender' => 'Female'],
            // ID: 42
            ['name' => 'Nadia Jibril', 'email' => 'nadia.jibril@example.com', 'password' => Hash::make('password'), 'role' => 'Employee', 'gender' => 'Female'],
            // ID: 43
            ['name' => 'Rami Salem', 'email' => 'rami.salem@example.com', 'password' => Hash::make('password'), 'role' => 'Employee', 'gender' => 'Male'],
            // ID: 44
            ['name' => 'Fatima Hussein', 'email' => 'fatima.hussein@example.com', 'password' => Hash::make('password'), 'role' => 'Employee', 'gender' => 'Female'],
            // ID: 45
            ['name' => 'Ibrahim Zaid', 'email' => 'ibrahim.zaid@example.com', 'password' => Hash::make('password'), 'role' => 'Employee', 'gender' => 'Male'],
            // ID: 46
            ['name' => 'Zainab Saleh', 'email' => 'zainab.saleh@example.com', 'password' => Hash::make('password'), 'role' => 'Employee', 'gender' => 'Female'],
            // ID: 47
            ['name' => 'Mahmoud Karim', 'email' => 'mahmoud.karim@example.com', 'password' => Hash::make('password'), 'role' => 'Employee', 'gender' => 'Male'],
            // ID: 48
            ['name' => 'Yasmin Abdul', 'email' => 'yasmin.abdul@example.com', 'password' => Hash::make('password'), 'role' => 'Employee', 'gender' => 'Female'],
            // ID: 49
            ['name' => 'Karim Awad', 'email' => 'karim.awad@example.com', 'password' => Hash::make('password'), 'role' => 'Employee', 'gender' => 'Male'],
            // ID: 50
            ['name' => 'Salma Fathi', 'email' => 'salma.fathi@example.com', 'password' => Hash::make('password'), 'role' => 'Employee', 'gender' => 'Female'],
            // ID: 51
            ['name' => 'Omar Ziad', 'email' => 'omar.ziad@example.com', 'password' => Hash::make('password'), 'role' => 'Employee', 'gender' => 'Male'],

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
