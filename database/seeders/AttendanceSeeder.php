<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceSeeder extends Seeder
{
    public function run(): void
    {
        $attendances = [
            [
                'employee_id' => 1,
                'attendance_date' => Carbon::parse('2024-08-01'),
                'clock_in' => '09:00:00',
                'clock_out' => '17:00:00',
                'total_hours' => 8,
                'leave_hours' => null,
                'status' => 'Present',
            ],
            [
                'employee_id' => 2,
                'attendance_date' => Carbon::parse('2024-08-01'),
                'clock_in' => null,
                'clock_out' => null,
                'total_hours' => null,
                'leave_hours' => null,
                'status' => 'Absent',
            ],
            [
                'employee_id' => 3,
                'attendance_date' => Carbon::parse('2024-08-01'),
                'clock_in' => null,
                'clock_out' => null,
                'total_hours' => null,
                'leave_hours' => null,
                'status' => 'Sick Leave',
            ],
            [
                'employee_id' => 4,
                'attendance_date' => Carbon::parse('2024-08-01'),
                'clock_in' => '08:30:00',
                'clock_out' => '16:30:00',
                'total_hours' => 6,
                'leave_hours' => 2,
                'status' => 'Hourly Leave',
            ],
            [
                'employee_id' => 5,
                'attendance_date' => Carbon::parse('2024-08-01'),
                'clock_in' => null,
                'clock_out' => null,
                'total_hours' => null,
                'leave_hours' => null,
                'status' => 'Annual Leave',
            ],
        ];

        foreach ($attendances as $attendance) {
            Attendance::create($attendance);
        }
    }
}
