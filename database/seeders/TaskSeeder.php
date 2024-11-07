<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\EmployeeDetail;
use App\Models\Project;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $tasks = [
            [
                'name' => 'Set up product database schema',
                'description' => 'Create the database schema for product management, including categories, attributes, and inventory.',
                'project_id' => 1,
                'employee_id' => 1, 
                'status' => 'in progress',
                'priority' => 'high',
                'start_date' => '2024-10-01',
                'end_date' => '2024-10-15',
            ],
            [
                'name' => 'Design landing page',
                'description' => 'Design the main landing page for the e-commerce platform with a focus on UX/UI.',
                'project_id' => 1,
                'employee_id' => 7,
                'status' => 'completed',
                'priority' => 'medium',
                'start_date' => '2024-10-05',
                'end_date' => '2024-10-20',
            ],
            [
                'name' => 'Integrate payment gateway',
                'description' => 'Set up and integrate the payment gateway for credit card transactions.',
                'project_id' => 1,
                'employee_id' => 13,
                'status' => 'completed',
                'priority' => 'high',
                'start_date' => '2024-10-10',
                'end_date' => '2024-10-25',
            ],
            [
                'name' => 'Test order flow',
                'description' => 'Test the complete order flow from product selection to payment confirmation.',
                'project_id' => 1,
                'employee_id' => 18,
                'status' => 'completed',
                'priority' => 'medium',
                'start_date' => '2024-10-15',
                'end_date' => '2024-10-30',
            ],
            [
                'name' => 'Develop user authentication',
                'description' => 'Implement the user authentication system using OAuth for login and registration.',
                'project_id' => 1,
                'employee_id' => 24,
                'status' => 'in progress',
                'priority' => 'high',
                'start_date' => '2024-10-05',
                'end_date' => '2024-10-20',
            ],
            [
                'name' => 'Set up shopping cart functionality',
                'description' => 'Develop and test the shopping cart functionality with persistent cart options.',
                'project_id' => 1,
                'employee_id' => 31,
                'status' => 'completed',
                'priority' => 'medium',
                'start_date' => '2024-10-15',
                'end_date' => '2024-10-30',
            ],
            [
                'name' => 'Optimize product search',
                'description' => 'Implement an efficient search engine for finding products by category and attributes.',
                'project_id' => 1,
                'employee_id' => 1,
                'status' => 'in progress',
                'priority' => 'medium',
                'start_date' => '2024-10-20',
                'end_date' => '2024-11-10',
            ],
            [
                'name' => 'Research payment gateway options',
                'description' => 'Research and list the most secure payment gateways for integration.',
                'project_id' => 2,
                'employee_id' => 7,
                'status' => 'in progress',
                'priority' => 'low',
                'start_date' => '2024-10-10',
                'end_date' => '2024-10-25',
            ],
            [
                'name' => 'Develop API wrapper for gateway',
                'description' => 'Create a custom API wrapper for integrating with the payment gateway.',
                'project_id' => 2,
                'employee_id' => 1,
                'status' => 'completed',
                'priority' => 'high',
                'start_date' => '2024-10-20',
                'end_date' => '2024-11-05',
            ],
            [
                'name' => 'Create wireframes for the new website',
                'description' => 'Develop wireframes for all major pages on the new corporate website.',
                'project_id' => 3,
                'employee_id' => 13,
                'status' => 'completed',
                'priority' => 'medium',
                'start_date' => '2024-10-05',
                'end_date' => '2024-10-20',
            ],
            [
                'name' => 'Implement front-end design',
                'description' => 'Convert the wireframes into responsive front-end code.',
                'project_id' => 3,
                'employee_id' => 18,
                'status' => 'completed',
                'priority' => 'high',
                'start_date' => '2024-10-15',
                'end_date' => '2024-11-01',
            ],
            [
                'name' => 'Add push notification feature',
                'description' => 'Integrate push notifications for real-time user updates.',
                'project_id' => 4,
                'employee_id' => 24,
                'status' => 'completed',
                'priority' => 'medium',
                'start_date' => '2024-10-25',
                'end_date' => '2024-11-10',
            ],
            [
                'name' => 'Develop chat functionality',
                'description' => 'Implement real-time chat functionality between users and support.',
                'project_id' => 4,
                'employee_id' => 31,
                'status' => 'in progress',
                'priority' => 'high',
                'start_date' => '2024-10-01',
                'end_date' => '2024-10-30',
            ],
        ];

        foreach ($tasks as $taskData) {
            $task = Task::create($taskData);

            $employeeId = $task->employee_id;
            $projectId = $task->project_id;

            $employee = EmployeeDetail::find($employeeId);

            if ($employee) {
                // Attach the employee to the project via the pivot table
                $employee->projects()->syncWithoutDetaching($projectId);
            }
        }
    }
}
