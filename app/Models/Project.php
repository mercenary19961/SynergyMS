<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'department_id',
        'description',
        'project_manager_id',
        'client_id',
        'status',
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function projectManager()
    {
        return $this->belongsTo(ProjectManager::class, 'project_manager_id');
    }

    public function employees()
    {
        return $this->belongsToMany(EmployeeDetail::class, 'employee_project', 'project_id', 'employee_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'project_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
    
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function taskEmployees()
    {
        return $this->hasManyThrough(User::class, Task::class, 'project_id', 'id', 'id', 'employee_id')->distinct();
    }
}
