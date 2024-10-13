<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HumanResources;
use App\Models\Position;

class HumanResourcesSeeder extends Seeder
{
    public function run(): void
    {
        $positions = Position::pluck('id', 'name');
        $humanResourcesEmployees = [
            [
                'user_id' => 4,
                'department_id' => 7,
                'position_id' => $positions['Recruitment Manager'],
                'contact_number' => '+962791234567',
                'company_email' => 'hrmanager@example.com',
            ],
            [
                'user_id' => 21,
                'department_id' => 8,
                'position_id' => $positions['Payroll Specialist'],
                'contact_number' => '+962791234568',
                'company_email' => 'payrollspecialist@example.com',
            ],
            [
                'user_id' => 22,
                'department_id' => 9,
                'position_id' => $positions['Employee Relations Specialist'],
                'contact_number' => '+962791234569',
                'company_email' => 'employeeofficer@example.com',
            ],
            [
                'user_id' => 23,
                'department_id' => 10,
                'position_id' => $positions['Training Coordinator'],
                'contact_number' => '+962791234570',
                'company_email' => 'trainingcoordinator@example.com',
            ],
            [
                'user_id' => 24,
                'department_id' => 11,
                'position_id' => $positions['Compliance Officer'],
                'contact_number' => '+962791234571',
                'company_email' => 'complianceofficer@example.com',
            ],
        ];

        foreach ($humanResourcesEmployees as $hrData) {
            HumanResources::create($hrData);
        }
    }
}
