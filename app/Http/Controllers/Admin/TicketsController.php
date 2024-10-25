<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Ticket;
use App\Models\EmployeeDetail;
use App\Models\ProjectManager;
use Illuminate\Http\Request;

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
}
