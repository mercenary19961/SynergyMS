<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Notifications extends Component
{
    public $notifications;

    public function mount()
    {
        // Fetch unread notifications for the current user
        $this->notifications = Auth::user()->unreadNotifications;
    }

    public function markAsRead($notificationId)
    {
        $user = Auth::user();
        $notification = $user->notifications()->find($notificationId);
    
        if ($notification) {
            $notification->markAsRead();
            // Refresh the notifications list by fetching the unread notifications again
            $this->notifications = Auth::user()->unreadNotifications;
        }
    }

    public function render()
    {
        return view('livewire.notifications');
    }
}

