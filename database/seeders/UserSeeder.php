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
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'password' => Hash::make('password'),
                'role' => 'Super Admin',
                'gender' => 'Male',
                'image' => 'users/My image.jpg',
            ],
            // ID: 2
            [
                'name' => 'Tech Solutions',
                'email' => 'techsolutions@example.com',
                'password' => Hash::make('password'),
                'role' => 'Client',
                'gender' => 'Female',
                'image' => 'clients/Tech Solutions.jpg',
            ],
            // ID: 3
            [
                'name' => 'Manager Khaled',
                'email' => 'mkhaled@example.com',
                'password' => Hash::make('password'),
                'role' => 'Project Manager',
                'gender' => 'Male',
                'image' => 'project_managers/first manager.jpg',
            ],
            // ID: 4
            [
                'name' => 'HR Soundos',
                'email' => 'hrsoundos@example.com',
                'password' => Hash::make('password'),
                'role' => 'HR',
                'gender' => 'Female',
                'image' => 'human_resources/HR Soundos.jpg',
            ],
            // ID: 5
            [
                'name' => 'Mohammad Jameel',
                'email' => 'mohammad.jameel@example.com',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'gender' => 'Male',
                'image' => 'employee_images/employee_5.jpg',
            ],
            // ID: 6
            [
                'name' => 'Anna Johansson',
                'email' => 'anna.ohansson@example.com',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'gender' => 'Female',
                'image' => 'employee_images/employee_6.jpg',
            ],
            // ID: 7
            [
                'name' => 'Ahmad Saeed',
                'email' => 'ahmad.saeed@example.com',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'gender' => 'Male',
                'image' => 'employee_images/employee_7.jpg',
            ],
            // ID: 8
            [
                'name' => 'Omar Khaled',
                'email' => 'omar.khaled@example.com',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'gender' => 'Male',
                'image' => 'employee_images/employee_8.jpg',
            ],
            // ID: 9
            [
                'name' => 'Caitlin Johnson',
                'email' => 'caitlin.johnson@example.com',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'gender' => 'Female',
                'image' => 'employee_images/employee_9.jpg',
            ],
            // ID: 10
            [
                'name' => 'Monica Anderson',
                'email' => 'monica.anderson@example.com',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'gender' => 'Female',
                'image' => 'employee_images/employee_10.jpg',
            ],
            // ID: 11
            [
                'name' => 'Ahmad Qasem',
                'email' => 'ahmadqasem@example.com',
                'password' => Hash::make('password'),
                'role' => 'Project Manager',
                'gender' => 'Male',
                'image' => 'project_managers/Ahmad Qasem.jpg',
            ],
            // ID: 12
            [
                'name' => 'Katrina Vanya',
                'email' => 'katrinavanya@example.com',
                'password' => Hash::make('password'),
                'role' => 'Project Manager',
                'gender' => 'Female',
                'image' => 'project_managers/Katrina Vanya.jpg',
            ],
            // ID: 13
            [
                'name' => 'Khaled Yaseen',
                'email' => 'khaledyaseen@example.com',
                'password' => Hash::make('password'),
                'role' => 'Project Manager',
                'gender' => 'Male',
                'image' => 'project_managers/Khaled Yaseen.jpg',
            ],
            // ID: 14
            [
                'name' => 'Omar Farouk',
                'email' => 'omarfarouk@example.com',
                'password' => Hash::make('password'),
                'role' => 'Project Manager',
                'gender' => 'Male',
                'image' => 'project_managers/Omar Farouk.jpg',
            ],
            // ID: 15
            [
                'name' => 'Lina Samara',
                'email' => 'linasamara@example.com',
                'password' => Hash::make('password'),
                'role' => 'Project Manager',
                'gender' => 'Female',
                'image' => 'project_managers/Lina Samara.jpg',
            ],
            // ID: 16
            [
                'name' => 'MediaCorp',
                'email' => 'mediacorp@example.com',
                'password' => Hash::make('password'),
                'role' => 'Client',
                'gender' => 'Female',
                'image' => 'clients/MediaCorp.jpg',
            ],
            // ID: 17
            [
                'name' => 'HealthCare Plus',
                'email' => 'healthcareplus@example.com',
                'password' => Hash::make('password'),
                'role' => 'Client',
                'gender' => 'Female',
                'image' => 'clients/HealthCare Plus.jpg',
            ],
            // ID: 18
            [
                'name' => 'FinServe Group',
                'email' => 'finserve@example.com',
                'password' => Hash::make('password'),
                'role' => 'Client',
                'gender' => 'Male',
                'image' => 'clients/FinServe Group.jpg',
            ],
            // ID: 19
            [
                'name' => 'EnergyCo',
                'email' => 'energyco@example.com',
                'password' => Hash::make('password'),
                'role' => 'Client',
                'gender' => 'Male',
                'image' => 'clients/EnergyCo.jpg',
            ],
            // ID: 20
            [
                'name' => 'EduSmart Academy',
                'email' => 'edusmartacademy@example.com',
                'password' => Hash::make('password'),
                'role' => 'Client',
                'gender' => 'Female',
                'image' => 'clients/EduSmart Academy.jpg',
            ],
            // ID: 21
            [
                'name' => 'HR Roger Fleet',
                'email' => 'hrrogerfleet@example.com',
                'password' => Hash::make('password'),
                'role' => 'HR',
                'gender' => 'Male',
                'image' => 'human_resources/HR Roger Fleet.jpg',
            ],
            // ID: 22
            [
                'name' => 'HR Clara',
                'email' => 'hrClara@example.com',
                'password' => Hash::make('password'),
                'role' => 'HR',
                'gender' => 'Female',
                'image' => 'human_resources/HR Clara.jpg',
            ],
            // ID: 23
            [
                'name' => 'HR Ranilla',
                'email' => 'hrRanilla@example.com',
                'password' => Hash::make('password'),
                'role' => 'HR',
                'gender' => 'Female',
                'image' => 'human_resources/HR Ranilla.jpg',
            ],
            // ID: 24
            [
                'name' => 'HR Omar',
                'email' => 'hromar@example.com',
                'password' => Hash::make('password'),
                'role' => 'HR',
                'gender' => 'Male',
                'image' => 'human_resources/HR Omar.jpg',
            ],

            // Newly Added Users (Employees)
            // ID: 25
            [
                'name' => 'Layla Fathi',
                'email' => 'layla.fathi@example.com',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'gender' => 'Female',
                'image' => 'employee_images/employee_25.jpg',
            ],
            // ID: 26
            [
                'name' => 'Abdelrahman Ali',
                'email' => 'abdelrahman.ali@example.com',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'gender' => 'Male',
                'image' => 'employee_images/employee_26.jpg',
            ],
            // ID: 27
            [
                'name' => 'Hana Rami',
                'email' => 'hana.rami@example.com',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'gender' => 'Female',
                'image' => 'employee_images/employee_27.jpg',
            ],
            // ID: 28
            [
                'name' => 'Tarek Abdul',
                'email' => 'tarek.abdul@example.com',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'gender' => 'Male',
                'image' => 'employee_images/employee_28.jpg',
            ],
            // ID: 29
            [
                'name' => 'Malak Saleh',
                'email' => 'malak.saleh@example.com',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'gender' => 'Female',
                'image' => 'employee_images/employee_29.jpg',
            ],
            // ID: 30
            [
                'name' => 'Khalil Mohammed',
                'email' => 'khalil.mohammed@example.com',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'gender' => 'Male',
                'image' => 'employee_images/employee_30.jpg',
            ],
            // ID: 31
            [
                'name' => 'Samir Nabil',
                'email' => 'samir.nabil@example.com',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'gender' => 'Male',
                'image' => 'employee_images/employee_31.jpg',
            ],
            // ID: 32
            [
                'name' => 'Lina Omar',
                'email' => 'lina.omar@example.com',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'gender' => 'Female',
                'image' => 'employee_images/employee_32.jpg',
            ],
            // ID: 33
            [
                'name' => 'Marwan Taha',
                'email' => 'marwan.taha@example.com',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'gender' => 'Male',
                'image' => 'employee_images/employee_33.jpg',
            ],
            // ID: 34
            [
                'name' => 'Abeer Yassin',
                'email' => 'abeer.yassin@example.com',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'gender' => 'Female',
                'image' => 'employee_images/employee_34.jpg',
            ],
            // ID: 35
            [
                'name' => 'Rania Mansour',
                'email' => 'rania.mansour@example.com',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'gender' => 'Female',
                'image' => 'employee_images/employee_35.jpg',
            ],
            // ID: 36
            [
                'name' => 'Youssef Khaled',
                'email' => 'youssef.khaled@example.com',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'gender' => 'Male',
                'image' => 'employee_images/employee_36.jpg',
            ],
            // ID: 37
            [
                'name' => 'Fatima Zayed',
                'email' => 'fatima.zayed@example.com',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'gender' => 'Female',
                'image' => 'employee_images/employee_37.jpg',
            ],
            // ID: 38
            [
                'name' => 'Mariam Faris',
                'email' => 'mariam.faris@example.com',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'gender' => 'Female',
                'image' => 'employee_images/employee_38.jpg',
            ],
            // ID: 39
            [
                'name' => 'Ali Hassan',
                'email' => 'ali.hassan@example.com',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'gender' => 'Male',
                'image' => 'employee_images/employee_39.jpg',
            ],
            // ID: 40
            [
                'name' => 'Ahmed Mahmoud',
                'email' => 'ahmed.mahmoud@example.com',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'gender' => 'Male',
                'image' => 'employee_images/employee_40.jpg',
            ],
            // ID: 41
            [
                'name' => 'Maysa Tarek',
                'email' => 'maysa.tarek@example.com',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'gender' => 'Female',
                'image' => 'employee_images/employee_41.jpg',
            ],
            // ID: 42
            [
                'name' => 'Nadia Jibril',
                'email' => 'nadia.jibril@example.com',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'gender' => 'Female',
                'image' => 'employee_images/employee_42.jpg',
            ],
            // ID: 43
            [
                'name' => 'Rami Salem',
                'email' => 'rami.salem@example.com',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'gender' => 'Male',
                'image' => 'employee_images/employee_43.jpg',
            ],
            // ID: 44
            [
                'name' => 'Fatima Hussein',
                'email' => 'fatima.hussein@example.com',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'gender' => 'Female',
                'image' => 'employee_images/employee_44.jpg',
            ],
            // ID: 45
            [
                'name' => 'Ibrahim Zaid',
                'email' => 'ibrahim.zaid@example.com',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'gender' => 'Male',
                'image' => 'employee_images/employee_45.jpg',
            ],
            // ID: 46
            [
                'name' => 'Zainab Saleh',
                'email' => 'zainab.saleh@example.com',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'gender' => 'Female',
                'image' => 'employee_images/employee_46.jpg',
            ],
            // ID: 47
            [
                'name' => 'Mahmoud Karim',
                'email' => 'mahmoud.karim@example.com',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'gender' => 'Male',
                'image' => 'employee_images/employee_47.jpg',
            ],
            // ID: 48
            [
                'name' => 'Yasmin Abdul',
                'email' => 'yasmin.abdul@example.com',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'gender' => 'Female',
                'image' => 'employee_images/employee_48.jpg',
            ],
            // ID: 49
            [
                'name' => 'Karim Awad',
                'email' => 'karim.awad@example.com',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'gender' => 'Male',
                'image' => 'employee_images/employee_49.jpg',
            ],
            // ID: 50
            [
                'name' => 'Salma Fathi',
                'email' => 'salma.fathi@example.com',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'gender' => 'Female',
                'image' => 'employee_images/employee_50.jpg',
            ],
            // ID: 51
            [
                'name' => 'Omar Ziad',
                'email' => 'omar.ziad@example.com',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'gender' => 'Male',
                'image' => 'employee_images/employee_51.jpg',
            ],
            // ID: 52
            [
                'name' => 'Osama Karam',
                'email' => 'osama.karam@example.com',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'gender' => 'Male',
                'image' => 'employee_images/employee_52.jpg',
            ],
            // ID: 53
            [
                'name' => 'Yaseen Zaid',
                'email' => 'yaseen.zaid@example.com',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'gender' => 'Male',
            ],
        ];

        foreach ($users as $index => $userData) {
            $user = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => $userData['password'],
                'gender' => $userData['gender'],
                'image' => $userData['image'] ?? null,
            ]);

            $user->assignRole($userData['role']);
        }
    }
}
