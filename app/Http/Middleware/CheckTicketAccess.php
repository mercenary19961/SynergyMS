<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class CheckTicketAccess
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $ticket = Ticket::find($request->route('ticket'));

        if (!$ticket) {
            abort(404, 'Ticket not found');
        }

        $user = Auth::user();

        $isTicketIssuer = $user->id === $ticket->created_by;
        $isProjectManagerOfDepartment = $ticket->department 
            && $ticket->department->project_manager 
            && $ticket->department->project_manager->user_id === $user->id;
        $isSuperAdminOrHR = $user->hasRole('Super Admin');

        if ($isSuperAdminOrHR || $isProjectManagerOfDepartment || $isTicketIssuer) {
            return $next($request);
        }

        abort(403, 'Unauthorized access to this ticket');
    }
}
