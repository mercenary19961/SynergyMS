<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\ProjectManager;
use App\Models\EmployeeDetail;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        // Define the project data without specifying department_id.
        $projects = [
            [
                'name' => 'E-Commerce Platform Development',
                'description' => 'Building a scalable e-commerce platform for local businesses.',
                'project_manager_id' => 1,
                'client_id' => 1,
                'start_date' => '2024-06-01',
                'end_date' => '2024-12-01',
                'status' => 'In Progress'
            ],
            [
                'name' => 'API Integration for Payment Gateways',
                'description' => 'Integrating payment gateway APIs for secure online transactions.',
                'project_manager_id' => 1,
                'client_id' => 1,
                'start_date' => '2024-03-01',
                'end_date' => '2024-11-09',
                'status' => 'Pending'
            ],
            [
                'name' => 'Website Redesign Initiative',
                'description' => 'Complete redesign of the corporate website for improved UX/UI.',
                'project_manager_id' => 1,
                'client_id' => 2,
                'start_date' => '2024-05-01',
                'end_date' => '2024-12-18',
                'status' => 'Pending'
            ],
            [
                'name' => 'Mobile App Feature Expansion',
                'description' => 'Adding new features and capabilities to the mobile application.',
                'project_manager_id' => 1,
                'client_id' => 1,
                'start_date' => '2024-06-15',
                'end_date' => '2024-10-15',
                'status' => 'In Progress'
            ],
            [
                'name' => 'Network Optimization',
                'description' => 'Improving network infrastructure to increase speed and security.',
                'project_manager_id' => 2,
                'client_id' => 2,
                'start_date' => '2024-04-01',
                'end_date' => '2024-12-04',
                'status' => 'Pending'
            ],
            [
                'name' => 'Firewall Implementation',
                'description' => 'Installing and configuring firewalls for enhanced security.',
                'project_manager_id' => 2,
                'client_id' => 2,
                'start_date' => '2024-05-01',
                'end_date' => '2024-10-01',
                'status' => 'In Progress'
            ],
            [
                'name' => 'Data Analytics Tool Development',
                'description' => 'Developing in-house tools for advanced data analytics.',
                'project_manager_id' => 3,
                'client_id' => 3,
                'start_date' => '2024-01-01',
                'end_date' => '2024-07-01',
                'status' => 'Completed'
            ],
            [
                'name' => 'Customer Data Analysis',
                'description' => 'Analyzing customer data for behavior trends and insights.',
                'project_manager_id' => 3,
                'client_id' => 3,
                'start_date' => '2024-02-01',
                'end_date' => '2024-06-01',
                'status' => 'In Progress'
            ],
            [
                'name' => 'IT Helpdesk Automation',
                'description' => 'Automating IT helpdesk operations using AI chatbots.',
                'project_manager_id' => 4,
                'client_id' => 4,
                'start_date' => '2024-01-15',
                'end_date' => '2024-05-15',
                'status' => 'Completed'
            ],
            [
                'name' => 'Remote Support System Implementation',
                'description' => 'Implementing a remote support system for employees.',
                'project_manager_id' => 4,
                'client_id' => 4,
                'start_date' => '2024-03-10',
                'end_date' => '2024-09-10',
                'status' => 'Pending'
            ],
            [
                'name' => 'Software Quality Improvement Initiative',
                'description' => 'Improving software quality through better testing protocols.',
                'project_manager_id' => 5,
                'client_id' => 5,
                'start_date' => '2024-03-05',
                'end_date' => '2024-08-05',
                'status' => 'In Progress'
            ],
            [
                'name' => 'Automated Testing Tool Development',
                'description' => 'Developing tools for automated testing of software applications.',
                'project_manager_id' => 5,
                'client_id' => 5,
                'start_date' => '2024-04-10',
                'end_date' => '2024-10-10',
                'status' => 'In Progress'
            ],
            [
                'name' => 'Redesign of Main Website UI',
                'description' => 'Revamping the company’s main website for a modern look and better user experience.',
                'project_manager_id' => 6,
                'client_id' => 6,
                'start_date' => '2024-02-20',
                'end_date' => '2024-06-20',
                'status' => 'Pending'
            ],
            [
                'name' => 'Mobile Application UX Improvement',
                'description' => 'Enhancing the user experience for the mobile application.',
                'project_manager_id' => 6,
                'client_id' => 6,
                'start_date' => '2024-03-15',
                'end_date' => '2024-07-15',
                'status' => 'In Progress'
            ],
        ];

        foreach ($projects as $projectData) {
            $projectManager = ProjectManager::find($projectData['project_manager_id']);
            $departmentId = $projectManager->department_id;

            $projectData['department_id'] = $departmentId;

            Project::create($projectData);
        }
    }
}
