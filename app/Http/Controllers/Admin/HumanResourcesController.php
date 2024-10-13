<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HumanResources;
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class HumanResourcesController extends Controller
{
    public function index(Request $request)
    {
        $departments = Department::where('sector', 'HR')->get();
        $query = HumanResources::with(['user', 'department']);

        if ($request->filled('name')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%');
            });
        }

        if ($request->filled('id')) {
            $query->where('id', $request->id);
        }

        if ($request->filled('department')) {
            $query->whereHas('department', function ($q) use ($request) {
                $q->where('name', $request->department)
                  ->where('sector', 'HR');
            });
        }

        $hrEmployees = $query->paginate(8);
        return view('admin.human-resources.index', compact('hrEmployees', 'departments'));
    }

    public function create()
    {
        $users = User::whereDoesntHave('roles', function ($query) {
            $query->whereIn('name', ['Super Admin', 'Client', 'Project Manager', 'HR']);
        })->get();
        $departments = Department::with('positions')->where('sector', 'HR')->get();
        return view('admin.human-resources.create', compact('users', 'departments'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'gender' => 'required|in:Male,Female',
            'contact_number' => 'required|string|max:20',
            'company_email' => 'required|email|max:255',
            'department_id' => 'required|exists:departments,id',
            'position_id' => 'required|exists:positions,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validatedData['password'] = bcrypt($validatedData['password']);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('human_resources', 'public');
        }

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => $validatedData['password'],
            'gender' => $validatedData['gender'],
            'image' => $imagePath,
        ]);

        HumanResources::create([
            'user_id' => $user->id,
            'department_id' => $validatedData['department_id'],
            'position_id' => $validatedData['position_id'],
            'contact_number' => $validatedData['contact_number'],
            'company_email' => $validatedData['company_email'],
        ]);

        return redirect()->route('admin.human-resources.index')->with('success', 'HR Employee added successfully.');
    }

    public function edit($id)
    {
        $hrEmployee = HumanResources::with('user', 'department', 'position')->findOrFail($id);
        $departments = Department::with('positions')->get();
        return view('admin.human-resources.edit', compact('hrEmployee', 'departments'));
    }

    public function update(Request $request, $id)
    {
        $hrEmployee = HumanResources::with('user')->findOrFail($id);
        $user = $hrEmployee->user;

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'gender' => 'required|in:Male,Female',
            'contact_number' => 'required|string|max:20',
            'company_email' => 'required|email|max:255',
            'department_id' => 'required|exists:departments,id',
            'position_id' => 'required|exists:positions,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->gender = $validatedData['gender'];

        if (!empty($validatedData['password'])) {
            $user->password = bcrypt($validatedData['password']);
        }

        if ($request->hasFile('image')) {
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }
            $imagePath = $request->file('image')->store('human_resources', 'public');
            $user->image = $imagePath;
        }

        $user->save();

        $hrEmployee->department_id = $validatedData['department_id'];
        $hrEmployee->position_id = $validatedData['position_id'];
        $hrEmployee->contact_number = $validatedData['contact_number'];
        $hrEmployee->company_email = $validatedData['company_email'];
        $hrEmployee->save();

        return redirect()->route('admin.human-resources.index')->with('success', 'HR Employee updated successfully.');
    }

    public function destroy(HumanResources $humanResource)
    {
        $humanResource->delete();
        return redirect()->route('admin.human-resources.index')->with('success', 'HR Employee deleted successfully.');
    }

    public function show(HumanResources $humanResource)
    {
        return view('admin.human-resources.show', compact('humanResource'));
    }
}
