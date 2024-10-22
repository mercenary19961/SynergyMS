<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Ticket;
use App\Models\EmployeeDetail;
use App\Models\HumanResources;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function show()
    {
        // Define the positions we are interested in
        $hrPositions = ['Payroll Manager', 'Employee Relations Specialist', 'Compliance Officer'];
    
        // Initialize an empty collection for HR contacts
        $hrContacts = collect();
    
        // Loop through each position and fetch the corresponding HR representative
        foreach ($hrPositions as $positionName) {
            $hrContact = HumanResources::whereHas('position', function($query) use ($positionName) {
                    $query->where('name', $positionName);
                })
                ->with('user')
                ->first();
    
            // If we find a contact, we add it to the collection
            if ($hrContact) {
                $hrContacts->push($hrContact);
            }
        }
    
        // Find the Technical Support department
        $techSupportDepartment = Department::where('name', 'Technical Support')->first();
    
        return view('pages.support', compact('hrContacts', 'techSupportDepartment'));
    }
    

    public function submit(Request $request)
    {
        // Validate the input data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'priority' => 'required|string|in:low,medium,high',
        ]);

        // Find the Technical Support department
        $techSupportDepartment = Department::where('name', 'Technical Support')->first();

        // Find an available employee in Technical Support
        $supportEmployee = EmployeeDetail::whereHas('position', function($query) {
            $query->where('name', 'Support Technician')
                  ->orWhere('name', 'IT Support Specialist')
                  ->orWhere('name', 'Help Desk Technician')
                  ->orWhere('name', 'Technical Support Engineer')
                  ->orWhere('name', 'Customer Support Specialist');
        })->where('department_id', $techSupportDepartment->id)->first();

        // Create a new ticket
        $ticket = Ticket::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'priority' => $validated['priority'],
            'status' => 'pending', // Initial status as pending
            'employee_id' => $supportEmployee->id, // Assign the support employee
        ]);

        // Redirect with success message
        return redirect()->route('support')->with('status', 'Your ticket has been submitted successfully!');
    }
}
