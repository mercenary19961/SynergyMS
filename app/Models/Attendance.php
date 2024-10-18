<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EmployeeDetail;

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
        'leave_hours',
        'status',
    ];

    protected $casts = [
        'attendance_date' => 'datetime',
        'clock_in' => 'datetime:H:i',
        'clock_out' => 'datetime:H:i',
    ];

    protected $workingHours = ['start' => '09:00', 'end' => '18:00'];

    public function isLate()
    {
        return strtotime($this->clock_in) > strtotime($this->workingHours['start']);
    }

    public function leftEarly()
    {
        return $this->clock_out && strtotime($this->clock_out) < strtotime($this->workingHours['end']);
    }

    public function employee()
    {
        return $this->belongsTo(EmployeeDetail::class);
    }

    public function projectManager()
    {
        return $this->hasOneThrough(ProjectManager::class, EmployeeDetail::class, 'id', 'employee_id', 'employee_id', 'id');
    }
}
