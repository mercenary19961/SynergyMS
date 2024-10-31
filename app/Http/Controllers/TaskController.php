<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\EmployeeDetail;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Store a newly created task in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|string',
            'employee_id' => 'required|exists:employee_details,id',
            'project_id' => 'required|exists:projects,id',
        ]);
    
        // Create the task with default status as "Pending"
        Task::create([
            'name' => $request->name,
            'description' => $request->description,
            'priority' => $request->priority,
            'status' => 'Pending', // Default status
            'employee_id' => $request->employee_id,
            'project_id' => $request->project_id,
        ]);
    
        return redirect()->route('admin.projects.show', $request->project_id)
                         ->with('success', 'Task added successfully.');
    }
    
    public function create(Task $task)
    {
        // Get employees in the same department as the project
        $employees = EmployeeDetail::where('department_id', $task->project->department_id)->with('user')->get();
        return view('admin.projects.show', compact('employees'));
    }

    public function show($id)
    {
        $task = Task::with('employee.user')->findOrFail($id);
        return response()->json($task);
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'employee_id' => 'required|exists:employee_details,id',
            'status' => 'required|string',
            'priority' => 'required|string',
        ]);

        // Update the task with validated data
        $task->update($request->only('name', 'employee_id', 'status', 'priority'));

        return redirect()->back()->with('success', 'Task updated successfully.');
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->back()->with('success', 'Task deleted successfully');
    }


}
