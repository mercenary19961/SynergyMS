<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Event;

class EventNotification extends Notification
{
    use Queueable;

    protected $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
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
        return [
            'event_id' => $this->event->id,
            'name' => $this->event->name,
            'description' => $this->event->description,
            'start_date' => $this->event->start_date->format('Y-m-d H:i:s'),
            'end_date' => $this->event->end_date ? $this->event->end_date->format('Y-m-d H:i:s') : null,
            'is_general' => $this->event->is_general,
            'target_role' => $this->event->target_role,
            'target_department_id' => $this->event->target_department_id,
        ];
    }
}
