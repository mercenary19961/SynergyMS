<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\EmployeeDetail;
use App\Models\Project;
use App\Models\Ticket;
use App\Models\Department;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class HRDashboardController extends Controller
{
    public function index()
    {
        // Retrieve data for HR Dashboard
        $employees = EmployeeDetail::all();
        $projects = Project::all();
        $tickets = Ticket::all();
        $notifications = Auth::user()->notifications;
        $departments = Department::all();

        return view('pages.hr.hr-dashboard', compact('employees', 'projects', 'tickets', 'notifications', 'departments'));
    }
}

