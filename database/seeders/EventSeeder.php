<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Event::insert([
            [
                'name' => 'Annual Company Retreat',
                'description' => 'A company-wide retreat to discuss vision and team-building activities.',
                'start_date' => Carbon::now()->addDays(5)->setTime(10, 0),
                'end_date' => Carbon::now()->addDays(5)->setTime(16, 0),
                'is_general' => 1, // Set to true with integer 1
                'target_role' => null,
                'target_department_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Quarterly Performance Review',
                'description' => 'Performance review for all employees in HR and Management.',
                'start_date' => Carbon::now()->addDays(10)->setTime(9, 0),
                'end_date' => Carbon::now()->addDays(10)->setTime(12, 0),
                'is_general' => 0,
                'target_role' => 'HR',
                'target_department_id' => null, // Explicitly set to null
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Client Project Kickoff',
                'description' => 'Initial meeting with the new client for project initiation.',
                'start_date' => Carbon::now()->addDays(15)->setTime(11, 0),
                'end_date' => Carbon::now()->addDays(15)->setTime(13, 0),
                'is_general' => 0,
                'target_role' => 'Project Manager',
                'target_department_id' => null, // Explicitly set to null
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tech Workshop',
                'description' => 'Workshop on new technology stack for the IT department.',
                'start_date' => Carbon::now()->addDays(20)->setTime(14, 0),
                'end_date' => Carbon::now()->addDays(20)->setTime(17, 0),
                'is_general' => 0,
                'target_role' => null,
                'target_department_id' => 1, // Set department ID
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'End-of-Year Party',
                'description' => 'Annual end-of-year celebration party for all employees.',
                'start_date' => Carbon::now()->addMonths(1)->setTime(18, 0),
                'end_date' => Carbon::now()->addMonths(1)->setTime(23, 0),
                'is_general' => 1,
                'target_role' => null,
                'target_department_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
