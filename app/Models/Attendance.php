<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EmployeeDetail;
use Carbon\Carbon;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendances';

    protected $fillable = [
        'employee_id',
        'project_manager_id',
        'attendance_date',
        'clock_in',
        'clock_out',
        'total_hours',
        'leave_hours', // Hours taken for leave
        'status', // Status options: Present, Absent, Hourly Leave, Sick Leave
    ];

    protected $casts = [
        'attendance_date' => 'datetime',
        'clock_in' => 'datetime:H:i',
        'clock_out' => 'datetime:H:i',
    ];

    protected $workingHours = ['start' => '09:00', 'end' => '18:00'];

    // Method to calculate total hours worked
    public function calculateTotalHours()
    {
        if ($this->clock_in && $this->clock_out) {
            $this->total_hours = Carbon::parse($this->clock_out)->diffInHours(Carbon::parse($this->clock_in));
            $this->save();
        }
    }

    // Method to set attendance status based on conditions
    public function setStatus($type = 'Present')
    {
        // Set status based on type, default is "Present"
        switch ($type) {
            case 'Hourly Leave':
                $this->status = 'Hourly Leave';
                break;
            case 'Sick Leave':
                $this->status = 'Sick Leave';
                break;
            case 'Absent':
                $this->status = 'Absent';
                break;
            default:
                $this->status = 'Present';
        }
        $this->save();
    }

    public function employeeDetail()
    {
        return $this->belongsTo(EmployeeDetail::class, 'employee_id', 'user_id');
    }

    public function projectManager()
    {
        return $this->hasOneThrough(ProjectManager::class, EmployeeDetail::class, 'id', 'employee_id', 'employee_id', 'id');
    }
}
