<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificationBell extends Component
{
    public $unreadNotifications;
    public $notificationOpen = false;

    protected $listeners = [
        'notificationReceived' => 'updateNotificationCount',
        'closeDropdown' => 'closeDropdown'
    ];

    public function mount()
    {
        $this->unreadNotifications = Auth::user()->unreadNotifications->count();
    }

    public function toggleNotificationDropdown()
    {
        $this->notificationOpen = !$this->notificationOpen;

        if ($this->notificationOpen) {
            Auth::user()->unreadNotifications->markAsRead();
            $this->unreadNotifications = 0;
            $this->dispatch('dropdownOpened');
        }
    }

    public function updateNotificationCount()
    {
        $this->unreadNotifications = Auth::user()->unreadNotifications->count();
    }

    public function closeDropdown()
    {
        $this->notificationOpen = false;
    }

    public function render()
    {
        return view('livewire.notification-bell');
    }
}

