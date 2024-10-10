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
                'sector' => 'Projects',
                'positions' => ['Software Developer', 'Frontend Developer', 'Backend Developer', 'Full Stack Developer', 'DevOps Engineer'],
            ],
            'Network Engineering' => [
                'description' => 'Responsible for network infrastructure, setup, and maintenance.',
                'sector' => 'Projects',
                'positions' => ['Network Engineer', 'Network Administrator', 'Network Architect', 'Network Security Specialist', 'Wireless Network Engineer'],
            ],
            'Data Analysis' => [
                'description' => 'Focuses on analyzing data, generating insights, and creating reports.',
                'sector' => 'Projects',
                'positions' => ['Data Analyst', 'Business Intelligence Analyst', 'Data Scientist', 'Data Engineer', 'Data Visualization Specialist'],
            ],
            'Technical Support' => [
                'description' => 'Provides technical support and troubleshooting for clients and internal staff.',
                'sector' => 'Projects',
                'positions' => ['Support Technician', 'IT Support Specialist', 'Help Desk Technician', 'Technical Support Engineer', 'Customer Support Specialist'],
            ],
            'Quality Assurance' => [
                'description' => 'Ensures quality through testing and verification processes.',
                'sector' => 'Projects',
                'positions' => ['QA Tester', 'QA Engineer', 'Quality Assurance Analyst', 'Test Automation Engineer', 'QA Manager'],
            ],
            'UX/UI' => [
                'description' => 'Focuses on designing user experiences and interfaces to ensure usability and aesthetic appeal.',
                'sector' => 'Projects',
                'positions' => ['UX Designer', 'UI Designer', 'Product Designer', 'UX Researcher', 'Interaction Designer'],
            ],
            'Recruitment' => [
                'description' => 'Handles recruitment and talent acquisition tasks.',
                'sector' => 'HR',
                'positions' => ['Recruitment Specialist', 'Talent Acquisition Specialist', 'HR Recruiter', 'Senior Recruitment Consultant', 'Recruitment Manager'],
            ],
            'Payroll' => [
                'description' => 'Responsible for payroll processing and compensation management.',
                'sector' => 'HR',
                'positions' => ['Payroll Coordinator', 'Payroll Specialist', 'Payroll Administrator', 'Payroll Manager', 'Compensation and Benefits Specialist'],
            ],
            'Employee Relations' => [
                'description' => 'Handles employee relations, conflict resolution, and labor relations.',
                'sector' => 'HR',
                'positions' => ['Employee Relations Specialist', 'Employee Relations Manager', 'Labor Relations Specialist', 'HR Generalist', 'Conflict Resolution Specialist'],
            ],
            'Training & Development' => [
                'description' => 'Handles employee training, learning, and development programs.',
                'sector' => 'HR',
                'positions' => ['Training Coordinator', 'Learning and Development Specialist', 'Training Manager', 'Corporate Trainer', 'Instructional Designer'],
            ],
            'Compliance' => [
                'description' => 'Ensures compliance with regulations and legal standards.',
                'sector' => 'HR',
                'positions' => ['Compliance Officer', 'HR Compliance Specialist', 'Legal and Compliance Manager', 'Risk and Compliance Analyst', 'HR Auditor'],
            ],
        ];

        foreach ($departmentsWithPositions as $name => $data) {
            $department = Department::create([
                'name' => $name,
                'description' => $data['description'],
                'sector' => $data['sector'],
            ]);

            foreach ($data['positions'] as $positionName) {
                Position::create([
                    'name' => $positionName,
                    'department_id' => $department->id,
                ]);
            }
        }
    }
}
