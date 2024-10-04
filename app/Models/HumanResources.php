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
        'department',
        'position',
        'contact_number',
        'company_email',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
