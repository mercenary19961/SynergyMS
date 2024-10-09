<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HumanResources;

class HumanResourcesSeeder extends Seeder
{
    public function run(): void
    {
        $humanResourcesEmployees = [
            [
                'user_id' => 4,
                'department' => 'Recruitment',
                'position' => 'HR Manager',
                'contact_number' => '+962791234567',
                'company_email' => 'hrmanager@example.com',
            ],
            [
                'user_id' => 21,
                'department' => 'Payroll',
                'position' => 'Payroll Specialist',
                'contact_number' => '+962791234568',
                'company_email' => 'payrollspecialist@example.com',
            ],
            [
                'user_id' => 22,
                'department' => 'Employee Relations',
                'position' => 'Employee Relations Officer',
                'contact_number' => '+962791234569',
                'company_email' => 'employeeofficer@example.com',
            ],
            [
                'user_id' => 23,
                'department' => 'Training & Development',
                'position' => 'Training Coordinator',
                'contact_number' => '+962791234570',
                'company_email' => 'trainingcoordinator@example.com',
            ],
            [
                'user_id' => 24,
                'department' => 'Compliance',
                'position' => 'Compliance Officer',
                'contact_number' => '+962791234571',
                'company_email' => 'complianceofficer@example.com',
            ],
        ];

        foreach ($humanResourcesEmployees as $hrData) {
            HumanResources::create($hrData);
        }
    }
}
