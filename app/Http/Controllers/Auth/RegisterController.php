<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ProjectManager;
use App\Models\HumanResources;
use App\Models\Department;
use App\Models\Position;
use App\Models\Client;
use App\Models\EmployeeDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function create()
    {
        $departments = Department::all();
        $positions = Position::all();
        return view('auth.register', compact('departments', 'positions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role_id' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        switch ($request->role_id) {
            case 3: // Project Manager
                $request->validate([
                    'department_id' => 'required|integer',
                    'experience_years_display' => 'required|integer|min:0',
                    'contact_number_display' => 'required|string',
                ]);

                ProjectManager::create([
                    'user_id' => $user->id,
                    'department_id' => $request->department_id, // Using department_id from request
                    'experience_years' => $request->experience_years_display,
                    'contact_number' => $request->contact_number_display,
                ]);
                break;

            case 4: // HR
                $request->validate([
                    'department_id' => 'required|integer',
                    'position_display' => 'required|string',
                    'contact_number_display' => 'required|string',
                    'company_email_display' => 'required|string|email',
                ]);

                HumanResources::create([
                    'user_id' => $user->id,
                    'department' => $request->department_display,
                    'position' => $request->position_display,
                    'contact_number' => $request->contact_number_display,
                    'company_email' => $request->company_email_display,
                ]);
                break;

            case 5: // Employee
                $request->validate([
                    'department_id' => 'required|integer',
                    'position_display' => 'required|string',
                    'salary_display' => 'required|numeric',
                    'date_of_joining_display' => 'required|date',
                    'address' => 'required|string',
                    'nationality' => 'required|string',
                    'age' => 'required|integer|min:0',
                    'date_of_birth' => 'required|date',
                ]);

                EmployeeDetail::create([
                    'user_id' => $user->id,
                    'department_id' => $request->department_id,
                    'position' => $request->position_display,
                    'salary' => $request->salary_display,
                    'date_of_joining' => $request->date_of_joining_display,
                    'address' => $request->address,
                    'nationality' => $request->nationality,
                    'age' => $request->age,
                    'date_of_birth' => $request->date_of_birth,
                ]);
                break;

            case 2: // Client
                $request->validate([
                    'department_id' => 'required|integer',
                    'industry_display' => 'required|string',
                    'address_display' => 'required|string',
                    'website' => 'nullable|string',
                    'contact_number' => 'required|string',
                ]);

                Client::create([
                    'user_id' => $user->id,
                    'company_name' => $request->company_name_display,
                    'industry' => $request->industry_display,
                    'address' => $request->address_display,
                    'contact_number' => $request->contact_number,
                    'website' => $request->website,
                ]);
                break;
        }

        return redirect()->route('login')->with('status', 'User registered successfully!');
    }
}
