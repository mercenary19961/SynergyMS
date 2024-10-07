<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Position;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departmentsWithPositions = [
            'Software Development' => [
                'description' => 'Handles all software development and engineering tasks.',
                'positions' => ['Software Developer', 'Frontend Developer', 'Backend Developer', 'Full Stack Developer', 'DevOps Engineer'],
            ],
            'Network Engineering' => [
                'description' => 'Responsible for network infrastructure, setup, and maintenance.',
                'positions' => ['Network Engineer', 'Network Administrator', 'Network Architect', 'Network Security Specialist', 'Wireless Network Engineer'],
            ],
            'Data Analysis' => [
                'description' => 'Focuses on analyzing data, generating insights, and creating reports.',
                'positions' => ['Data Analyst', 'Business Intelligence Analyst', 'Data Scientist', 'Data Engineer', 'Data Visualization Specialist'],
            ],
            'Technical Support' => [
                'description' => 'Provides technical support and troubleshooting for clients and internal staff.',
                'positions' => ['Support Technician', 'IT Support Specialist', 'Help Desk Technician', 'Technical Support Engineer', 'Customer Support Specialist'],
            ],
            'Quality Assurance' => [
                'description' => 'Ensures quality through testing and verification processes.',
                'positions' => ['QA Tester', 'QA Engineer', 'Quality Assurance Analyst', 'Test Automation Engineer', 'QA Manager'],
            ],
            'UX/UI' => [
                'description' => 'Focuses on designing user experiences and interfaces to ensure usability and aesthetic appeal.',
                'positions' => ['UX Designer', 'UI Designer', 'Product Designer', 'UX Researcher', 'Interaction Designer'],
            ],
            // Additional HR departments
            'Recruitment' => [
                'description' => 'Handles recruitment and talent acquisition tasks.',
                'positions' => ['Recruitment Specialist', 'Talent Acquisition Specialist', 'HR Recruiter', 'Senior Recruitment Consultant', 'Recruitment Manager'],
            ],
            'Payroll' => [
                'description' => 'Responsible for payroll processing and compensation management.',
                'positions' => ['Payroll Coordinator', 'Payroll Specialist', 'Payroll Administrator', 'Payroll Manager', 'Compensation and Benefits Specialist'],
            ],
            'Employee Relations' => [
                'description' => 'Handles employee relations, conflict resolution, and labor relations.',
                'positions' => ['Employee Relations Specialist', 'Employee Relations Manager', 'Labor Relations Specialist', 'HR Generalist', 'Conflict Resolution Specialist'],
            ],
            'Training & Development' => [
                'description' => 'Handles employee training, learning, and development programs.',
                'positions' => ['Training Coordinator', 'Learning and Development Specialist', 'Training Manager', 'Corporate Trainer', 'Instructional Designer'],
            ],
            'Compliance' => [
                'description' => 'Ensures compliance with regulations and legal standards.',
                'positions' => ['Compliance Officer', 'HR Compliance Specialist', 'Legal and Compliance Manager', 'Risk and Compliance Analyst', 'HR Auditor'],
            ],
        ];

        foreach ($departmentsWithPositions as $name => $data) {
            $department = Department::create([
                'name' => $name,
                'description' => $data['description'],
            ]);

            // Seed positions related to the department
            foreach ($data['positions'] as $positionName) {
                Position::create([
                    'name' => $positionName,
                    'department_id' => $department->id,
                ]);
            }
        }
    }
}
