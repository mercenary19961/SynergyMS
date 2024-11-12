<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class EventAccessControl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $event = $request->route('event');

        // Check if the event exists
        if (!$event || !$event instanceof Event) {
            abort(404); // Return 404 if event is not found
        }

        // Check if the user meets any of the access criteria
        $userDepartmentId = $user->employeeDetail ? $user->employeeDetail->department_id : ($user->humanResource ? $user->humanResource->department_id : null);
        $isSuperAdminOrHR = $user->hasRole(['Super Admin', 'HR']);
        $isSameDepartment = $event->target_department_id && $event->target_department_id === $userDepartmentId;
        $isSameRole = $event->target_role && $user->hasRole($event->target_role);
        $isGeneralEvent = $event->is_general;

        // If the user doesn't meet any of these criteria, deny access
        if (!($isSuperAdminOrHR || $isGeneralEvent || $isSameDepartment || $isSameRole)) {
            abort(403, 'Unauthorized access to this event.');
        }

        return $next($request);
    }
}
