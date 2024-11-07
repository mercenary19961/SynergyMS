<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class NotificationPage extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public function markAsRead($id)
    {
        $user = Auth::user();
        $notification = $user->notifications()->find($id);

        if ($notification) {
            $notification->markAsRead();
        }
    }

    public function deleteNotification($id)
    {
        $user = Auth::user();
        $notification = $user->notifications()->find($id);

        if ($notification) {
            $notification->delete();
        }
    }

    public function render()
    {
        $notifications = Auth::user()->notifications()->paginate(6);
        return view('livewire.notification-page', ['notifications' => $notifications]);
    }
}
