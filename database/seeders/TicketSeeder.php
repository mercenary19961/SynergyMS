<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;
use Carbon\Carbon;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tickets = [
            [
                'title' => 'Fix Login Issue',
                'description' => 'Users are unable to login with correct credentials.',
                'status' => 'In Progress',
                'priority' => 'High',
                'employee_id' => 1,
                'project_manager_id' => 1,
                'department_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Database Optimization',
                'description' => 'Optimize database queries for better performance.',
                'status' => 'In Progress',
                'priority' => 'Medium',
                'employee_id' => 2,
                'project_manager_id' => 1,
                'department_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'UI Bug in Dashboard',
                'description' => 'UI components overlapping on the main dashboard.',
                'status' => 'Open',
                'priority' => 'Low',
                'employee_id' => null,
                'project_manager_id' => null,
                'department_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'API Integration Failure',
                'description' => 'External API integration is failing intermittently.',
                'status' => 'Closed',
                'priority' => 'High',
                'employee_id' => 4,
                'project_manager_id' => 1,
                'department_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Data Migration Task',
                'description' => 'Migrate old user data to the new system.',
                'status' => 'Confirmed',
                'priority' => 'High',
                'employee_id' => 1,
                'project_manager_id' => 3,
                'department_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Setup Email Server',
                'description' => 'Configure the email server for notification services.',
                'status' => 'In Progress',
                'priority' => 'Medium',
                'employee_id' => 2,
                'project_manager_id' => 2,
                'department_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Fix Password Reset Functionality',
                'description' => 'Password reset link is not being sent to users.',
                'status' => 'In Progress',
                'priority' => 'High',
                'employee_id' => 3,
                'project_manager_id' => 1,
                'department_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Add User Role Management',
                'description' => 'Implement role-based access control in the application.',
                'status' => 'Confirmed',
                'priority' => 'High',
                'employee_id' => 5,
                'project_manager_id' => 1,
                'department_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Fix Payment Gateway Error',
                'description' => 'Payment gateway is rejecting valid transactions.',
                'status' => 'Closed',
                'priority' => 'High',
                'employee_id' => 2,
                'project_manager_id' => 1,
                'department_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Refactor Codebase for Performance',
                'description' => 'Refactor the legacy codebase to improve performance.',
                'status' => 'In Progress',
                'priority' => 'Medium',
                'employee_id' => 6,
                'project_manager_id' => 2,
                'department_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($tickets as $ticket) {
            Ticket::create($ticket);
        }
    }
}
