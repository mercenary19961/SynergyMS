<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TicketReviewConfirmed extends Notification
{
    use Queueable;

    protected $ticket;

    public function __construct($ticket)
    {
        $this->ticket = $ticket;
    }

    public function via($notifiable)
    {
        return ['database']; // Optionally add 'mail' if email notification is required
    }

    public function toArray($notifiable)
    {
        return [
            'ticket_id' => $this->ticket->id,
            'ticket_title' => $this->ticket->title,
            'confirmed_by' => $this->ticket->projectManager->user->name ?? 'project-manager',
            'message' => 'The ticket has been successfully reviewed and marked as done.',
        ];
    }
}
