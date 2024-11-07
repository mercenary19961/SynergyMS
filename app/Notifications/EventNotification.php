<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Event;
use App\Models\User;

class EventNotification extends Notification
{
    use Queueable;

    protected $event;
    protected $type;
    protected $user;

    public function __construct(Event $event, $type, User $user = null)
    {
        $this->event = $event;
        $this->type = $type;
        $this->user = $user;
    }

    /**
     * Determine the notification delivery channels.
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Define the data representation of the notification.
     */
    public function toArray($notifiable)
    {
        $data = [
            'event_id' => $this->event->id,
            'name' => $this->event->name,
            'description' => $this->event->description,
            'start_date' => $this->event->start_date->format('Y-m-d H:i:s'),
            'end_date' => $this->event->end_date ? $this->event->end_date->format('Y-m-d H:i:s') : null,
            'is_general' => $this->event->is_general,
            'target_role' => $this->event->target_role,
            'target_department_id' => $this->event->target_department_id,
        ];

        // Customize message based on notification type and recipient
        if ($this->type === 'user_attending') {
            if ($notifiable->id === $this->user->id) {
                // Message for the attending user
                $data['message'] = 'You have successfully confirmed your attendance for the event.';
            } else {
                // Message for HR
                $data['message'] = "User {$this->user->name} has confirmed their attendance for the event.";
                $data['user_id'] = $this->user->id;
            }
        } elseif ($this->type === 'user_canceled') {
            if ($notifiable->id === $this->user->id) {
                // Message for the canceling user
                $data['message'] = "You have canceled your attendance for the event.";
            } else {
                // Message for HR
                $data['message'] = "User {$this->user->name} has canceled their attendance for the event.";
                $data['user_id'] = $this->user->id;
            }
        }

        return $data;
    }
}
