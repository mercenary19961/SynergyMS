<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\EmployeeDetail;
use App\Models\Project;
use App\Models\ProjectManager;
use Illuminate\Http\Request;

class TicketsController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with(['employee', 'project', 'projectManager'])->paginate(10);
        return view('admin.tickets.index', compact('tickets'));
    }

    public function show($id)
    {
        $ticket = Ticket::with(['employee', 'project', 'projectManager'])->findOrFail($id);
        return view('admin.tickets.show', compact('ticket'));
    }

    public function create()
    {
        $employees = EmployeeDetail::all();
        $projects = Project::all();
        $projectManagers = ProjectManager::all();
        return view('admin.tickets.create', compact('employees', 'projects', 'projectManagers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string',
            'priority' => 'required|string',
            'employee_id' => 'required|exists:employee_details,id',
            'project_id' => 'required|exists:projects,id',
            'project_manager_id' => 'required|exists:project_managers,id',
        ]);

        Ticket::create($validated);

        return redirect()->route('admin.tickets.index')->with('success', 'Ticket created successfully.');
    }

    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);
        $employees = EmployeeDetail::all();
        $projects = Project::all();
        $projectManagers = ProjectManager::all();
        return view('admin.tickets.edit', compact('ticket', 'employees', 'projects', 'projectManagers'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string',
            'priority' => 'required|string',
            'employee_id' => 'required|exists:employee_details,id',
            'project_id' => 'required|exists:projects,id',
            'project_manager_id' => 'required|exists:project_managers,id',
        ]);

        $ticket = Ticket::findOrFail($id);
        $ticket->update($validated);

        return redirect()->route('admin.tickets.index')->with('success', 'Ticket updated successfully.');
    }

    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();

        return redirect()->route('admin.tickets.index')->with('success', 'Ticket deleted successfully.');
    }
}
