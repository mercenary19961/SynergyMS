<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRecruitmentManager
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user->hasRole('Super Admin')) {
            return $next($request);
        }

        if ($user->hasRole('HR')) {
            // Check if the user's department is "Recruitment" and if their position is "Recruitment Manager"
            if ($user->employeeDetail && 
                $user->employeeDetail->department->name === 'Recruitment' &&
                $user->employeeDetail->position === 'Recruitment Manager') {
                
                // Allow access if all conditions are met
                return $next($request);
            }
        }

        // If conditions are not met, return a 403 error
        return abort(403, 'Unauthorized action.');
    }
}

