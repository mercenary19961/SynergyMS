<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Ticket;
use App\Models\EmployeeDetail;
use App\Models\ProjectManager;
use Illuminate\Http\Request;
use App\Notifications\TicketReviewRequested;
use App\Notifications\TicketReviewConfirmed;
use Illuminate\Support\Facades\Notification;

class TicketsController extends Controller
{
    public function index(Request $request)
    {
        $query = Ticket::with(['employee', 'projectManager']);

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->input('priority'));
        }

        if ($request->filled('employee')) {
            $query->whereHas('employee.user', function ($q) use ($request) {
                $q->where('name', $request->input('employee'));
            });
        }

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->input('title') . '%');
        }

        $tickets = $query->paginate(8);
        $employees = EmployeeDetail::all();
        
        return view('admin.tickets.index', compact('tickets', 'employees'));
    }

    public function show($id)
    {
        $ticket = Ticket::with(['employee', 'projectManager'])->findOrFail($id);
        return view('admin.tickets.show', compact('ticket'));
    }

    public function create()
    {
        $users = User::all();
        return view('admin.tickets.create', compact('users'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|string', 
            'user_id' => 'required|exists:users,id',
        ]);

        $validated['status'] = 'Open';

        Ticket::create($validated);

        return redirect()->route('admin.tickets.index')->with('success', 'Ticket created successfully.');
    }

    public function edit($id)
    {
        $ticket = Ticket::with('user')->findOrFail($id);
        $employees = EmployeeDetail::with('projectManager.user')->get();
        $projectManagers = ProjectManager::with('user')->get();
        
        return view('admin.tickets.edit', compact('ticket', 'employees', 'projectManagers'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|string',
            'project_manager_id' => 'required|exists:project_managers,id',
        ]);

        $ticket = Ticket::findOrFail($id);

        $ticket->employee_id = $request->employee_id;
        $ticket->project_manager_id = $request->project_manager_id;

        if ($ticket->status === 'Open' && $request->employee_id) {
            $ticket->status = 'In Progress';
        }

        $ticket->update($validated);

        return redirect()->route('admin.tickets.index')->with('success', 'Ticket updated and status reset to Open successfully.');
    }

    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();

        return redirect()->route('admin.tickets.index')->with('success', 'Ticket deleted successfully.');
    }

    public function takeTicket($id)
    {
        $ticket = Ticket::findOrFail($id);
        $employee = Auth::user()->employeeDetail;
        if (!$employee) {
            return redirect()->back()->with('error', 'Employee details not found.');
        }
    
        $department = $employee->department;
        $projectManager = $department->project_manager;
        if (!$department) {
            return redirect()->back()->with('error', 'Employee department not found.');
        }
        
        if (!$projectManager) {
            return redirect()->back()->with('error', 'Project manager not found for this department.');
        }
        // Update the ticket details
        $ticket->status = 'In Progress';
        $ticket->employee_id = $employee->id;
        $ticket->department_id = $department->id;
        $ticket->project_manager_id = $projectManager->id;
        $ticket->save();
    
        return redirect()->back()->with('success', 'Ticket taken successfully.');
    }
    
    public function sendBack($id)
    {
        $ticket = Ticket::findOrFail($id);
    
        // Reset the ticket details
        $ticket->status = 'Open';
        $ticket->employee_id = null;
        $ticket->department_id = null;
        $ticket->project_manager_id = null;
        $ticket->save();
    
        return redirect()->back()->with('success', 'Ticket sent back successfully.');
    }
    
    public function requestReview($id)
    {
        $ticket = Ticket::findOrFail($id);
        $employee = Auth::user()->employeeDetail;

        // Ensure the employee requesting review is the one assigned to the ticket
        if (!$employee || $ticket->employee_id !== $employee->id) {
            return redirect()->back()->with('error', 'You are not authorized to request a review for this ticket.');
        }

        // Retrieve the project manager for the department
        $projectManager = $ticket->department ? $ticket->department->project_manager : null;

        if ($projectManager && $projectManager->user) {
            // Send notification to the project manager
            $projectManager->user->notify(new TicketReviewRequested($ticket));
        }

        // Change the ticket status to "Closed"
        $ticket->status = 'Closed';
        $ticket->save();

        return redirect()->back()->with('success', 'Review request sent to the Project Manager, and ticket status set to Closed.');
    }

    public function confirmReview($id)
    {
        $ticket = Ticket::findOrFail($id);
        $projectManager = Auth::user()->projectManager;
    
        // Ensure only the project manager assigned to the ticket's department can confirm
        if (!$projectManager || $ticket->project_manager_id !== $projectManager->id) {
            return redirect()->back()->with('error', 'You are not authorized to confirm this review.');
        }
    
        // Confirm the review by setting the ticket status to "Confirmed"
        $ticket->status = 'Confirmed';
        $ticket->save();
    
        // Notify the ticket issuer that the review has been confirmed
        $issuer = $ticket->user;
        if ($issuer) {
            $issuer->notify(new TicketReviewConfirmed($ticket));
        }
    
        return redirect()->back()->with('success', 'Ticket review has been confirmed, and the ticket issuer has been notified.');
    }
    

}
