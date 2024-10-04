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
                'status' => 'Open',
                'priority' => 'High',
                'employee_id' => 1,
                'project_id' => 1,
                'project_manager_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Database Optimization',
                'description' => 'Optimize database queries for better performance.',
                'status' => 'In Progress',
                'priority' => 'Medium',
                'employee_id' => 2,
                'project_id' => 2,
                'project_manager_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'UI Bug in Dashboard',
                'description' => 'UI components overlapping on the main dashboard.',
                'status' => 'Open',
                'priority' => 'Low',
                'employee_id' => 3,
                'project_id' => 3,
                'project_manager_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($tickets as $ticket) {
            Ticket::create($ticket);
        }
    }
}
