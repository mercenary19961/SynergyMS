<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

/**
 * @method bool hasRole(string|array|\Spatie\Permission\Models\Role $roles, string|null $guard = null)
 * @method bool hasAnyRole(...$roles)
 * @method bool hasAllRoles(...$roles)
 */

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'gender',
        'image',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function humanResources()
    {
        return $this->hasMany(HumanResources::class);
    }

    public function employeeDetail()
    {
        return $this->hasOne(EmployeeDetail::class, 'user_id');
    }
}
