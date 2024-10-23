<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'employee_id',
        'name',
        'description',
        'status',
        'priority',
        'start_date',
        'end_date'
    ];

    // Each task belongs to a project
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // Each task can be assigned to an employee
    public function employee()
    {
        return $this->belongsTo(EmployeeDetail::class);
    }
}
