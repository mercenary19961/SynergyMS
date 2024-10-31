<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Department;
use Carbon\Carbon;

class EventsController extends Controller
{
    /**
     * Display a listing of the events.
     */
    public function index(Request $request)
    {
        $events = Event::query();
    
        // Apply filters if any
        if ($request->filled('name')) {
            $events->where('name', 'like', '%' . $request->name . '%');
        }
    
        if ($request->filled('target_role')) {
            if ($request->target_role === 'General') {
                // Filter for general events
                $events->where('is_general', true);
            } else {
                // Filter for specific target role or department
                $events->where('target_role', $request->target_role);
            }
        }
    
        $events = $events->paginate(10);
    
        // Fetch all unique roles and add "General" as an option
        $roles = ['General', 'Super Admin', 'HR', 'Project Manager', 'Employee']; // Adjust roles as needed
    
        return view('admin.events.index', compact('events', 'roles'));
    }
    

    /**
     * Show the form for creating a new event.
     */
    public function create()
    {
        $roles = ['Super Admin', 'HR', 'Project Manager', 'Employee'];
        $departments = Department::all();
    
        return view('admin.events.create', compact('roles', 'departments'));
    }
    

    /**
     * Store a newly created event in the database.
     */
    public function store(Request $request)
    {
        // Validate the input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_role' => 'nullable|string',
            'target_department_id' => 'nullable|exists:departments,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);
    
        // Set 'is_general' to true if checked, otherwise set to false
        $validatedData['is_general'] = $request->filled('is_general');

        // If 'target_department_id' is not provided, default to null
        $validatedData['target_department_id'] = $validatedData['target_department_id'] ?? null;
    
        // Create the event with the validated data
        Event::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'target_role' => $validatedData['target_role'],
            'target_department_id' => $validatedData['target_department_id'],
            'is_general' => $validatedData['is_general'],
            'start_date' => Carbon::parse($validatedData['start_date']),
            'end_date' => $validatedData['end_date'] ? Carbon::parse($validatedData['end_date']) : null,
        ]);
    
        // Redirect with success message
        return redirect()->route('admin.events.index')->with('success', 'Event created successfully.');
    }
    

    /**
     * Display the specified event.
     */
    public function show(Event $event)
    {
        // Format start and end dates if necessary
        $event->start_date = $event->start_date ? Carbon::parse($event->start_date)->format('F d, Y H:i') : null;
        $event->end_date = $event->end_date ? Carbon::parse($event->end_date)->format('F d, Y H:i') : 'No End Date';
    
        return view('admin.events.show', compact('event'));
    }
    

    /**
     * Show the form for editing the specified event.
     */
    public function edit(Event $event)
    {
        $departments = Department::all(); // Load departments for targeting by department
        $roles = ['Super Admin', 'HR', 'Project Manager', 'Employee']; // Define roles as in the create method
    
        // Ensure dates are Carbon instances
        $event->start_date = Carbon::parse($event->start_date);
        $event->end_date = $event->end_date ? Carbon::parse($event->end_date) : null;
    
        return view('admin.events.edit', compact('event', 'departments', 'roles'));
    }
    
    

    /**
     * Update the specified event in the database.
     */
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_role' => 'nullable|string',
            'target_department_id' => 'nullable|exists:departments,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // Set 'is_general' to true if the checkbox is checked, otherwise set to false
        $isGeneral = $request->has('is_general') ? true : false;

        $event->update([
            'name' => $request->name,
            'description' => $request->description,
            'target_role' => $request->target_role,
            'target_department_id' => $request->target_department_id,
            'is_general' => $isGeneral,
            'start_date' => Carbon::parse($request->start_date),
            'end_date' => $request->end_date ? Carbon::parse($request->end_date) : null,
        ]);

        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully.');
    }

    /**
     * Remove the specified event from the database.
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully.');
    }
}
