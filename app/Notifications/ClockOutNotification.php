<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class ClockOutNotification extends Notification
{
    use Queueable;

    protected $hoursWorked;

    /**
     * Create a new notification instance.
     *
     * @param float $hoursWorked
     * @return void
     */
    public function __construct($hoursWorked)
    {
        $this->hoursWorked = $hoursWorked;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database']; // Store in database to show in-app notification
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => 'Great job today! You have clocked out successfully.',
            'hours_worked' => $this->hoursWorked,
            'summary' => 'You worked a total of ' . $this->hoursWorked . ' hours today. Keep up the good work!',
        ];
    }
}
