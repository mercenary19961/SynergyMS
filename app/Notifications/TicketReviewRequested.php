<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;

class TicketReviewRequested extends Notification
{
    public $ticket;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    // Only use the database channel
    public function via($notifiable)
    {
        return ['database'];
    }

    // Database representation of the notification
    public function toArray($notifiable)
    {
        return [
            'ticket_id' => $this->ticket->id,
            'ticket_title' => $this->ticket->title,
            'message' => 'A review has been requested for this ticket.',
            'requested_by' => Auth::user()->name,
            'link' => route('admin.tickets.show', $this->ticket->id)
        ];
    }
}
