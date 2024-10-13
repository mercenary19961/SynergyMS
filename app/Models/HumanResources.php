<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HumanResources extends Model
{
    use HasFactory;

    protected $table = 'human_resources';

    protected $fillable = [
        'user_id',
        'department_id',
        'position_id',
        'contact_number',
        'company_email',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function position()
{
    return $this->belongsTo(Position::class);
}
}
