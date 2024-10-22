<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\HumanResources;
use App\Models\ProjectManager;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboardRedirect()
    {
        $user = Auth::user();

        // Redirect based on the user's role using Spatie
        if ($user->hasRole('Super Admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('Client')) {
            return redirect()->route('client.dashboard');
        } elseif ($user->hasRole('Project Manager')) {
            return redirect()->route('project-manager.dashboard');
        } elseif ($user->hasRole('HR')) {
            return redirect()->route('hr.dashboard');
        } elseif ($user->hasRole('Employee')) {
            return redirect()->route('employee.dashboard');
        }

        // Default fallback
        return redirect()->route('login');
    }

    public function profile()
    {
        $user = Auth::user();
    
        $clients = collect(); // Initialize an empty collection for clients
        $employees = collect(); // Initialize an empty collection for employees
        $humanResources = collect(); // Initialize an empty collection for HR employees
    
        if ($user->hasRole('Super Admin')) {
            // Fetch all clients for Super Admin
            $clients = Client::with('user')->get(); // You can paginate if needed
            $humanResources = HumanResources::with('user')->get();
            
        } elseif ($user->hasRole('Project Manager')) {
            // Load related data for Project Manager
            $projectManager = ProjectManager::where('user_id', $user->id)
                                            ->with(['department.employees.user', 'projects', 'department'])
                                            ->first();
    
            if ($projectManager) {
                $user->setRelation('projectManager', $projectManager); // Set the relation manually
                // Load employees in the same department
                $employees = $projectManager->department->employees;
            }
        } elseif ($user->hasRole('Employee')) {
            $user->load('employeeDetail.department', 'employeeDetail.position', 'employeeDetail.projects');
        } elseif ($user->hasRole('HR')) {
            $user->load('employeeDetail.department', 'employeeDetail.position');
        }
    
        return view('pages.profile', compact('user', 'clients', 'employees', 'humanResources'));
    }
    
}
