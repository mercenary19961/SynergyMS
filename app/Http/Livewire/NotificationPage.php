<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificationPage extends Component
{
    public $notifications;

    public function mount()
    {
        $this->notifications = Auth::user()->notifications;
    }

    public function markAsRead($id)
    {
        $user = Auth::user();
        $notification = $user->notifications()->find($id);

        if ($notification) {
            $notification->markAsRead();
        }

        // Refresh the notifications list
        $this->notifications = Auth::user()->notifications;
    }

    public function render()
    {
        return view('livewire.notification-page');
    }
}
