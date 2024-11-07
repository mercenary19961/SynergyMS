<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

/**
 * @method \Illuminate\Notifications\DatabaseNotificationCollection notifications()
 * @method bool hasRole(string|array|\Spatie\Permission\Models\Role $roles, string|null $guard = null)
 */
/**
 * @method \Illuminate\Database\Eloquent\Relations\BelongsToMany attendingEvents()
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

    public function humanResource()
    {
        return $this->hasOne(HumanResources::class, 'user_id');
    }

    public function employeeDetail()
    {
        return $this->hasOne(EmployeeDetail::class, 'user_id');
    }

    public function client()
    {
        return $this->hasOne(Client::class, 'user_id');
    }

    public function projectManager()
    {
        return $this->hasOne(ProjectManager::class, 'user_id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function events()
    {
        return $this->belongsToMany(Event::class)->withPivot('is_attending')->withTimestamps();
    }

    public function attendingEvents()
    {
        return $this->belongsToMany(Event::class, 'event_user', 'user_id', 'event_id')
                    ->wherePivot('is_attending', 1)
                    ->withTimestamps();
    }
}
