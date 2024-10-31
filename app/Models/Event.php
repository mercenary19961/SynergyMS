<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\EventNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\User;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'target_role',
        'target_department_id',
        'is_general',
        'start_date',
        'end_date',
    ];

    protected $dates = ['start_date', 'end_date'];

    public function department()
    {
        return $this->belongsTo(Department::class, 'target_department_id');
    }

    /**
     * Method to notify relevant users when the event is created.
     */
    public function notifyUsersForEvent()
    {
        $users = $this->determineNotificationRecipients();
        Notification::send($users, new EventNotification($this));
    }

    /**
     * Determine the notification recipients based on event properties.
     */
    protected function determineNotificationRecipients()
    {
        if ($this->is_general) {
            return User::all();
        } elseif ($this->target_role) {
            return User::role($this->target_role)->get();
        } elseif ($this->target_department_id) {
            return User::whereHas('employeeDetail', function ($query) {
                $query->where('department_id', $this->target_department_id);
            })->get();
        }

        return User::all();
    }

    /**
     * Boot method to dispatch notifications upon event creation.
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($event) {
            $event->notifyUsersForEvent();
        });
    }
}
