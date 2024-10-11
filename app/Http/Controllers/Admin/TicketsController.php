<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\EmployeeDetail;
use App\Models\ProjectManager;
use Illuminate\Http\Request;

class TicketsController extends Controller
{
    public function index(Request $request)
    {
        // Start a query for tickets
        $query = Ticket::with(['employee', 'projectManager']);
        
        // Filter by status if provided
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }
        
        // Filter by priority if provided
        if ($request->filled('priority')) {
            $query->where('priority', $request->input('priority'));
        }
        
        // Filter by employee if provided
        if ($request->filled('employee')) {
            $query->whereHas('employee.user', function ($q) use ($request) {
                $q->where('name', $request->input('employee'));
            });
        }
        
        // Paginate the filtered results
        $tickets = $query->paginate(8);
        
        // Get all employees for the dropdown
        $employees = EmployeeDetail::all();
        
        return view('admin.tickets.index', compact('tickets', 'employees'));
    }
    
    public function show($id)
    {
        // Removed project relationship
        $ticket = Ticket::with(['employee', 'projectManager'])->findOrFail($id);
        return view('admin.tickets.show', compact('ticket'));
    }

    public function create()
    {
        $projectManagers = ProjectManager::all();
        return view('admin.tickets.create', compact('projectManagers'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|string', 
            'project_manager_id' => 'required|exists:project_managers,id',
        ]);
    
        // Automatically set status to 'Open' when a new ticket is created
        $validated['status'] = 'Open';
    
        Ticket::create($validated);
    
        return redirect()->route('admin.tickets.index')->with('success', 'Ticket created successfully.');
    }
    

    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);
        $employees = EmployeeDetail::all();
        $projectManagers = ProjectManager::all();
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
    
        if ($ticket->project_manager_id != $request->project_manager_id) {
            $ticket->employee_id = null;
            $ticket->status = 'Open';
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
}
