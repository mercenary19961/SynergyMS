<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\EventNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\Event;
use App\Models\Position;
use App\Models\HumanResources;
use App\Models\Department;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


class EventsController extends Controller
{

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
    
    public function show(Event $event)
    {
        $user = Auth::user();
        $attendance = $user->events()->where('event_id', $event->id)->first();
    
        $isAttending = $attendance ? $attendance->pivot->is_attending : null;
        $toggleCount = $attendance->pivot->toggle_count ?? 0;
    
        // Format the start and end dates
        $event->start_date = $event->start_date ? Carbon::parse($event->start_date)->format('F d, Y H:i') : null;
        $event->end_date = $event->end_date ? Carbon::parse($event->end_date)->format('F d, Y H:i') : 'No End Date';
    
        // Get the count of confirmed attendees
        $confirmedAttendeesCount = $event->attendees()->wherePivot('is_attending', true)->count();
    
        return view('admin.events.show', compact('event', 'isAttending', 'toggleCount', 'confirmedAttendeesCount'));
    }
    
    public function attend(Event $event)
    {
        $user = Auth::user();
        $attendance = $user->events()->where('event_id', $event->id)->first();
    
        // Define the new status and toggle count logic
        if ($attendance) {
            $currentStatus = $attendance->pivot->is_attending;
            $toggleCount = $attendance->pivot->toggle_count ?? 0;
            $newStatus = !$currentStatus;
    
            if (!$newStatus && $toggleCount < 2) {
                // Increment toggle count for cancellation and update attendance status
                $toggleCount += 1;
                $user->events()->updateExistingPivot($event->id, [
                    'is_attending' => $newStatus,
                    'toggle_count' => $toggleCount,
                ]);
    
                // Send cancellation notification to the user
                $user->notify(new EventNotification($event, 'user_canceled', $user));
    
                // Notify only "Employee Relations Specialist"
                $this->notifyEmployeeRelationsSpecialist($event, 'user_canceled', $user);
    
            } elseif ($newStatus) {
                // Update attendance status to attending
                $user->events()->updateExistingPivot($event->id, [
                    'is_attending' => $newStatus,
                ]);
    
                // Send attendance confirmation notification to the user
                $user->notify(new EventNotification($event, 'user_attending', $user));
    
                // Notify only "Employee Relations Specialist"
                $this->notifyEmployeeRelationsSpecialist($event, 'user_attending', $user);
    
            } else {
                return redirect()->back()->with('error', 'You have reached the maximum number of cancellations.');
            }
        } else {
            // First-time attendance confirmation, set is_attending to true and initialize toggle_count to 0
            $user->events()->attach($event->id, [
                'is_attending' => true,
                'toggle_count' => 0,
            ]);
    
            // Send attendance confirmation notification to the user
            $user->notify(new EventNotification($event, 'user_attending', $user));
    
            // Notify only "Employee Relations Specialist"
            $this->notifyEmployeeRelationsSpecialist($event, 'user_attending', $user);
        }
    
        return redirect()->back()->with('success', 'Your attendance status has been updated.');
    }
    
    
    
    /**
     * Notify only the "Employee Relations Specialist" about attendance changes.
    */
    protected function notifyEmployeeRelationsSpecialist($event, $notificationType, $user)
    {
        // Find the "Employee Relations Specialist" in the HR department
        $specialist = User::whereHas('roles', function ($query) {
            $query->where('name', 'HR');
        })->whereHas('humanResource', function ($query) {
            $query->where('position_id', 41); // Assuming 41 is the ID for 'Employee Relations Specialist'
        })->first();
    
        // If the specialist exists, send them a notification about the user's attendance status change
        if ($specialist) {
            $specialist->notify(new EventNotification($event, $notificationType, $user));
        }
    }

    public function create()
    {
        $roles = ['Super Admin', 'HR', 'Project Manager', 'Employee'];
        $departments = Department::all();
    
        return view('admin.events.create', compact('roles', 'departments'));
    }
    
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
    
    public function edit(Event $event)
    {
        $departments = Department::all(); 
        $roles = ['Super Admin', 'HR', 'Project Manager', 'Employee'];
    
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
