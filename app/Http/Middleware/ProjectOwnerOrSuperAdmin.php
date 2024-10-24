<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectOwnerOrSuperAdmin
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
        // Get the current user
        $user = Auth::user();

        // Get the project from the route
        $project = $request->route('project');

        // Allow if the user is a Super Admin or the project manager of the project
        if ($user->hasRole('Super Admin') || $user->id === $project->projectManager->user_id) {
            return $next($request);
        }

        // Otherwise, deny access
        abort(403, 'Unauthorized access.');
    }
}

