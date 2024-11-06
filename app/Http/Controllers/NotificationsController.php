<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;

class NotificationsController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Query notifications with pagination
        $notifications = DatabaseNotification::where('notifiable_id', $user->id)
                            ->where('notifiable_type', get_class($user))
                            ->orderBy('created_at', 'desc')
                            ->paginate(9);
    
        // Store the current URL in the session
        session()->put('previous_url', url()->current());

        return view('pages.notifications', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $user = Auth::user();
        $notification = $user->notifications()->find($id);

        if ($notification) {
            $notification->markAsRead();
        }

        // Redirect to the stored previous URL or to the appropriate dashboard
        return redirect(session()->get('previous_url', route('dashboard.redirect')));
    }
}
