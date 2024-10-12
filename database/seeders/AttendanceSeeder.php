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
            // Day 1 - 2024-08-01
            [
                'employee_id' => 5,
                'attendance_date' => Carbon::parse('2024-08-01'),
                'clock_in' => '09:00:00',
                'clock_out' => '17:00:00',
                'total_hours' => 8,
                'leave_hours' => null,
                'status' => 'Present',
            ],
            [
                'employee_id' => 6,
                'attendance_date' => Carbon::parse('2024-08-01'),
                'clock_in' => null,
                'clock_out' => null,
                'total_hours' => null,
                'leave_hours' => null,
                'status' => 'Absent',
            ],
            [
                'employee_id' => 7,
                'attendance_date' => Carbon::parse('2024-08-01'),
                'clock_in' => null,
                'clock_out' => null,
                'total_hours' => null,
                'leave_hours' => null,
                'status' => 'Sick Leave',
            ],
            // Day 2 - 2024-08-02
            [
                'employee_id' => 8,
                'attendance_date' => Carbon::parse('2024-08-02'),
                'clock_in' => '08:30:00',
                'clock_out' => '16:30:00',
                'total_hours' => 6,
                'leave_hours' => 2,
                'status' => 'Hourly Leave',
            ],
            [
                'employee_id' => 9,
                'attendance_date' => Carbon::parse('2024-08-02'),
                'clock_in' => null,
                'clock_out' => null,
                'total_hours' => null,
                'leave_hours' => null,
                'status' => 'Annual Leave',
            ],
            [
                'employee_id' => 10,
                'attendance_date' => Carbon::parse('2024-08-02'),
                'clock_in' => '09:00:00',
                'clock_out' => '17:00:00',
                'total_hours' => 8,
                'leave_hours' => null,
                'status' => 'Present',
            ],
            // Day 3 - 2024-08-03
            [
                'employee_id' => 25,
                'attendance_date' => Carbon::parse('2024-08-03'),
                'clock_in' => '09:30:00',
                'clock_out' => '18:00:00',
                'total_hours' => 7.5,
                'leave_hours' => null,
                'status' => 'Present',
            ],
            [
                'employee_id' => 26,
                'attendance_date' => Carbon::parse('2024-08-03'),
                'clock_in' => null,
                'clock_out' => null,
                'total_hours' => null,
                'leave_hours' => null,
                'status' => 'Absent',
            ],
            [
                'employee_id' => 27,
                'attendance_date' => Carbon::parse('2024-08-03'),
                'clock_in' => '10:00:00',
                'clock_out' => '18:00:00',
                'total_hours' => 7,
                'leave_hours' => 1,
                'status' => 'Hourly Leave',
            ],
            // Day 4 - 2024-08-04
            [
                'employee_id' => 28,
                'attendance_date' => Carbon::parse('2024-08-04'),
                'clock_in' => '09:00:00',
                'clock_out' => '17:00:00',
                'total_hours' => 8,
                'leave_hours' => null,
                'status' => 'Present',
            ],
            [
                'employee_id' => 29,
                'attendance_date' => Carbon::parse('2024-08-04'),
                'clock_in' => null,
                'clock_out' => null,
                'total_hours' => null,
                'leave_hours' => null,
                'status' => 'Sick Leave',
            ],
            [
                'employee_id' => 30,
                'attendance_date' => Carbon::parse('2024-08-04'),
                'clock_in' => null,
                'clock_out' => null,
                'total_hours' => null,
                'leave_hours' => null,
                'status' => 'Annual Leave',
            ],
            // Day 5 - 2024-08-05
            [
                'employee_id' => 31,
                'attendance_date' => Carbon::parse('2024-08-05'),
                'clock_in' => '09:00:00',
                'clock_out' => '17:00:00',
                'total_hours' => 8,
                'leave_hours' => null,
                'status' => 'Present',
            ],
            [
                'employee_id' => 32,
                'attendance_date' => Carbon::parse('2024-08-05'),
                'clock_in' => null,
                'clock_out' => null,
                'total_hours' => null,
                'leave_hours' => null,
                'status' => 'Absent',
            ],
            [
                'employee_id' => 33,
                'attendance_date' => Carbon::parse('2024-08-05'),
                'clock_in' => '10:00:00',
                'clock_out' => '18:00:00',
                'total_hours' => 7,
                'leave_hours' => 1,
                'status' => 'Hourly Leave',
            ],
            // Day 6 - 2024-08-06
            [
                'employee_id' => 5,
                'attendance_date' => Carbon::parse('2024-08-06'),
                'clock_in' => '09:00:00',
                'clock_out' => '17:00:00',
                'total_hours' => 8,
                'leave_hours' => null,
                'status' => 'Present',
            ],
            [
                'employee_id' => 6,
                'attendance_date' => Carbon::parse('2024-08-06'),
                'clock_in' => '09:15:00',
                'clock_out' => '17:15:00',
                'total_hours' => 8,
                'leave_hours' => null,
                'status' => 'Present',
            ],
            [
                'employee_id' => 7,
                'attendance_date' => Carbon::parse('2024-08-06'),
                'clock_in' => '10:00:00',
                'clock_out' => '18:00:00',
                'total_hours' => 7,
                'leave_hours' => 1,
                'status' => 'Hourly Leave',
            ],
            // Day 7 - 2024-08-07
            [
                'employee_id' => 8,
                'attendance_date' => Carbon::parse('2024-08-07'),
                'clock_in' => '09:30:00',
                'clock_out' => '17:30:00',
                'total_hours' => 7.5,
                'leave_hours' => null,
                'status' => 'Present',
            ],
            [
                'employee_id' => 9,
                'attendance_date' => Carbon::parse('2024-08-07'),
                'clock_in' => '09:00:00',
                'clock_out' => '17:00:00',
                'total_hours' => 8,
                'leave_hours' => null,
                'status' => 'Present',
            ],
            [
                'employee_id' => 10,
                'attendance_date' => Carbon::parse('2024-08-07'),
                'clock_in' => '08:45:00',
                'clock_out' => '16:45:00',
                'total_hours' => 8,
                'leave_hours' => null,
                'status' => 'Present',
            ],
            // Day 8 - 2024-08-08
            [
                'employee_id' => 25,
                'attendance_date' => Carbon::parse('2024-08-08'),
                'clock_in' => '09:00:00',
                'clock_out' => '17:00:00',
                'total_hours' => 8,
                'leave_hours' => null,
                'status' => 'Present',
            ],
            [
                'employee_id' => 26,
                'attendance_date' => Carbon::parse('2024-08-08'),
                'clock_in' => '09:30:00',
                'clock_out' => '17:30:00',
                'total_hours' => 7.5,
                'leave_hours' => null,
                'status' => 'Present',
            ],
            [
                'employee_id' => 27,
                'attendance_date' => Carbon::parse('2024-08-08'),
                'clock_in' => '10:00:00',
                'clock_out' => '18:00:00',
                'total_hours' => 7,
                'leave_hours' => 1,
                'status' => 'Hourly Leave',
            ],
        ];

        foreach ($attendances as $attendance) {
            Attendance::create($attendance);
        }
    }
}
