<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeDetail extends Model
{
    use HasFactory;

    protected $table = 'employee_details';

    protected $fillable = [
        'user_id',
        'position',
        'salary',
        'date_of_joining',
        'address',
        'nationality',
        'age',
        'date_of_birth',
        'department_id',
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
        return $this->hasMany(Attendance::class, 'employee_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'employee_id');
    }
}
