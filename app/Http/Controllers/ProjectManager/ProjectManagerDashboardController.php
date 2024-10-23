<?php

namespace App\Http\Controllers\ProjectManager;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\ProjectManager;
use App\Models\Attendance;
use App\Models\Project;
use App\Models\Ticket;
use App\Models\EmployeeDetail;

class ProjectManagerDashboardController extends Controller
{
    public function index()
    {
        // Check if the authenticated user has the Project Manager role using Spatie
        $user = Auth::user();

        if (!$user->hasRole('Project Manager')) {
            abort(403, 'Unauthorized action.');
        }

        // Get the project manager information via the user's relation to ProjectManager
        $projectManager = ProjectManager::where('user_id', $user->id)
            ->with('user', 'department')
            ->first();

        if (!$projectManager) {
            abort(404, 'Project Manager not found.');
        }

        // Fetch the projects managed by this project manager (filtered by department) along with tasks
        $managedProjects = Project::where('project_manager_id', $projectManager->id)
            ->where('department_id', $projectManager->department_id)
            ->with('tasks')
            ->get();

        // Fetch employees managed by this project manager through their department
        $managedEmployees = EmployeeDetail::where('department_id', $projectManager->department_id)->get();

        // Fetch tickets that are open and not assigned to any specific employee (the pool of tickets)
        $tickets = Ticket::whereNull('employee_id')->get();

        // Fetch attendance records of the employees managed by the project manager
        $attendanceRecords = Attendance::whereIn('employee_id', $managedEmployees->pluck('id'))->get();

        // Calculate task progress for each project
        foreach ($managedProjects as $project) {
            // Fetch tasks that are either "in progress" or "completed"
            $relevantTasks = $project->tasks->whereIn('status', ['in progress', 'completed']);
            $completedTasks = $project->tasks->where('status', 'completed')->count();
            $inProgressTasks = $project->tasks->where('status', 'in progress')->count();
        
            // Set completed and in-progress tasks count
            $project->tasks_completed = $completedTasks;
            $project->tasks_open = $inProgressTasks;
        
            // Calculate progress percentage based on relevant tasks
            $totalRelevantTasks = $relevantTasks->count();
            $project->progress_percentage = $totalRelevantTasks > 0 ? round(($completedTasks / $totalRelevantTasks) * 100) : 0;
        }
        

        // Pass the fetched data to the view
        return view('pages.project-manager.projectManagerDashboard', compact(
            'projectManager', 'managedProjects', 'managedEmployees', 'tickets', 'attendanceRecords'
        ));
    }
}
