<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class EmployeeDetail extends Model
{
    use HasFactory, HasRoles;

    protected $table = 'employee_details';

    protected $fillable = [
        'user_id',
        'department_id',
        'position_id',
        'salary',
        'date_of_joining',
        'address',
        'nationality',
        'age',
        'date_of_birth',
        'image',
        'phone',
    ];

    // Cast date_of_joining and date_of_birth as dates
    protected $casts = [
        'date_of_joining' => 'date',
        'date_of_birth' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'employee_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'employee_id');
    }

    public function projectManager()
    {
        return $this->hasOneThrough(ProjectManager::class, Department::class, 'id', 'department_id', 'department_id', 'id');
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'employee_project', 'employee_id', 'project_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'employee_id', 'id');
    }

}
