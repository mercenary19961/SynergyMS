<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmployeeDetail; // Assuming Employee is a model
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    public function index()
    {
        $employees = EmployeeDetail::all(); // Get all employees
        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        return view('admin.employees.create');
    }

    public function store(Request $request)
    {
        // Validate and store new employee
        $request->validate([
            'name' => 'required',
            // Other validation rules...
        ]);

        EmployeeDetail::create($request->all());

        return redirect()->route('admin.employees.index')->with('success', 'Employee created successfully.');
    }

    public function edit($id)
    {
        $employee = EmployeeDetail::findOrFail($id);
        return view('admin.employees.edit', compact('employee'));
    }

    public function update(Request $request, $id)
    {
        // Validate and update employee
        $employee = EmployeeDetail::findOrFail($id);
        $employee->update($request->all());

        return redirect()->route('admin.employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy($id)
    {
        EmployeeDetail::findOrFail($id)->delete();
        return redirect()->route('admin.employees.index')->with('success', 'Employee deleted successfully.');
    }
}
