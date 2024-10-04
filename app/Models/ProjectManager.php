<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Project;

class ProjectManager extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'department_id',
        'experience_years',
        'contact_number',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'project_manager_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'project_manager_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'project_manager_id');
    }

    public function getAssignedProjectsCountAttribute()
    {
        return $this->projects()->count();
    }
}
