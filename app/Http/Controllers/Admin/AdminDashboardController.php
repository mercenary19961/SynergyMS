<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\EmployeeDetail;
use App\Models\Client;
use App\Models\Project;
use App\Models\Ticket;
use App\Models\Attendance;


class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalEmployees = EmployeeDetail::count();
        $totalClients = Client::count();
        $totalProjects = Project::count();
        $totalTickets = Ticket::count();
        
        $recentEmployees = EmployeeDetail::with(['user', 'department', 'position'])->latest()->limit(3)->get();
        $recentClients = Client::with('user')->latest()->limit(3)->get();
        $recentProjects = Project::with(['department', 'projectManager.user'])->latest()->limit(3)->get();
        $recentTickets = Ticket::with(['createdBy', 'department'])->latest()->limit(5)->get(); 

        // Use the Attendance model to get present and absent employees
        $presentEmployees = Attendance::where('status', 'Present')
            ->with('employee') // Eager load employee details
            ->get();

        $absentEmployees = Attendance::where('status', 'Absent')
            ->orWhereNull('clock_in') // Handle absent employees or those who haven't checked in
            ->with('employee')
            ->get();
    
        return view('admin.index', compact(
            'totalEmployees', 
            'totalClients', 
            'totalProjects', 
            'totalTickets', 
            'recentEmployees', 
            'recentClients', 
            'recentProjects', 
            'recentTickets', 
            'presentEmployees', 
            'absentEmployees'
        )); 
    }

}
