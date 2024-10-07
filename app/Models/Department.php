<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = 'departments';

    protected $fillable = ['name', 'description'];

    public function project_managers()
    {   
        return $this->hasMany(ProjectManager::class, 'department_id');
    }

    public function employees()
    {
        return $this->hasMany(EmployeeDetail::class, 'department_id');
    }

    public function positions()
    {
        return $this->hasMany(Position::class, 'department_id');
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'department_id');
    }
}
