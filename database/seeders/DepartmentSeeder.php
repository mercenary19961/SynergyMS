<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            ['name' => 'Software Development', 'description' => 'Handles all software development and engineering tasks.'],
            ['name' => 'Network Engineering', 'description' => 'Responsible for network infrastructure, setup, and maintenance.'],
            ['name' => 'Data Analysis', 'description' => 'Focuses on analyzing data, generating insights, and creating reports.'],
            ['name' => 'Technical Support', 'description' => 'Provides technical support and troubleshooting for clients and internal staff.'],
            ['name' => 'Quality Assurance', 'description' => 'Ensures quality through testing and verification processes.'],
            ['name' => 'UX/UI', 'description' => 'Focuses on designing user experiences and interfaces to ensure usability and aesthetic appeal.']
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}
