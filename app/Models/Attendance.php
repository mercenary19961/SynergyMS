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

    public function employee()
    {
        return $this->belongsTo(EmployeeDetail::class);
    }

    public function projectManager()
    {
        return $this->belongsTo(ProjectManager::class, 'project_manager_id');
    }
}
