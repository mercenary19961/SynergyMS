<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmployeeDetail;

class EmployeeDetailSeeder extends Seeder
{
    public function run(): void
    {
        $employees = [
            [
                'user_id' => 5,
                'department_id' => 1,
                'position' => 'Software Developer',
                'salary' => 1000.00,
                'date_of_joining' => '2021-05-12',
                'address' => 'Amman, Jordan',
                'nationality' => 'Jordan',
                'age' => 28,
                'date_of_birth' => '1996-03-15',
                'phone' => '+962799012345',
                'image' => 'employee_images/employee_5.jpg',
            ],
            [
                'user_id' => 6,
                'department_id' => 2,
                'position' => 'Network Engineer',
                'salary' => 1200.00,
                'date_of_joining' => '2019-08-01',
                'address' => 'Zarqa, Jordan',
                'nationality' => 'Jordan',
                'age' => 35,
                'date_of_birth' => '1989-02-20',
                'phone' => '+962781472346',
                'image' => 'employee_images/employee_6.jpg',
            ],
            [
                'user_id' => 7,
                'department_id' => 3,
                'position' => 'Data Analyst',
                'salary' => 800.00,
                'date_of_joining' => '2022-01-20',
                'address' => 'Cairo, Egypt',
                'nationality' => 'Egypt',
                'age' => 30,
                'date_of_birth' => '1993-07-10',
                'phone' => '+962788874347',
                'image' => 'employee_images/employee_7.jpg',
            ],
            [
                'user_id' => 8,
                'department_id' => 4,
                'position' => 'Support Technician',
                'salary' => 600.00,
                'date_of_joining' => '2020-03-15',
                'address' => 'Irbid, Jordan',
                'nationality' => 'Jordan',
                'age' => 42,
                'date_of_birth' => '1981-06-28',
                'phone' => '+962781157348',
                'image' => 'employee_images/employee_8.jpg',
            ],
            [
                'user_id' => 9,
                'department_id' => 5,
                'position' => 'Quality Assurance Tester',
                'salary' => 1000.00,
                'date_of_joining' => '2018-11-05',
                'address' => 'Alexandria, Egypt',
                'nationality' => 'Egypt',
                'age' => 38,
                'date_of_birth' => '1985-04-12',
                'phone' => '+962789012349',
                'image' => 'employee_images/employee_9.jpg',
            ],
            [
                'user_id' => 10,
                'department_id' => 6,
                'position' => 'UX/UI Designer',
                'salary' => 1500.00,
                'date_of_joining' => '2019-04-10',
                'address' => 'Amman, Jordan',
                'nationality' => 'Jordan',
                'age' => 32,
                'date_of_birth' => '1991-04-10',
                'phone' => '+962789054749',
                'image' => 'employee_images/employee_10.jpg',
            ],
        ];

        foreach ($employees as $employee) {
            EmployeeDetail::create($employee);
        }
    }
}
