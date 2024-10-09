<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClientsController extends Controller
{
    public function index()
    {
        // Pagination for clients with associated users
        $clients = Client::with('user')->paginate(8);
        return view('admin.clients.index', compact('clients'));
    }

    public function show($id)
    {
        // Load specific client with user and projects relationships
        $client = Client::with(['user', 'projects'])->findOrFail($id);
        return view('admin.clients.show', compact('client'));
    }

    public function create()
    {
        // Since we're creating new users for clients, no need to pass existing users here.
        return view('admin.clients.create');
    }

    public function store(Request $request)
    {
        // Validate both user and client inputs
        $request->validate([
            'user_name' => 'required|string|max:255',
            'user_email' => 'required|email|unique:users,email',
            'user_password' => 'required|string|min:6',
            'gender' => 'nullable|string|Male,Female',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'company_name' => 'required|string|max:255',
            'industry' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
        ]);

        // Handle the profile image upload if provided
        $profileImage = null;
        if ($request->hasFile('profile_image')) {
            $profileImage = $request->file('profile_image')->store('users', 'public');
        }

        // Create the user first
        $user = User::create([
            'name' => $request->input('user_name'),
            'email' => $request->input('user_email'),
            'password' => Hash::make($request->input('user_password')),
            'gender' => $request->input('gender'),
            'profile_image' => $profileImage,
        ]);

        // Assign the Client role to the user using Spatie
        $user->assignRole('Client');

        // Then create the client with the user's ID
        Client::create([
            'user_id' => $user->id,
            'company_name' => $request->input('company_name'),
            'industry' => $request->input('industry'),
            'contact_number' => $request->input('contact_number'),
            'address' => $request->input('address'),
            'website' => $request->input('website'),
        ]);

        return redirect()->route('admin.clients.index')->with('success', 'Client added successfully');
    }

    public function edit(Client $client)
    {
        // Fetch all users to allow changing the user for a client
        $users = User::all();
        return view('admin.clients.edit', compact('client', 'users'));
    }

    public function update(Request $request, Client $client)
    {
        // Validate the update fields for both user and client
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'company_name' => 'required|string|max:255',
            'industry' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
        ]);

        // Update the client details
        $client->update($request->all());

        return redirect()->route('admin.clients.index')->with('success', 'Client updated successfully');
    }

    public function destroy(Client $client)
    {
        // Delete the client record
        $client->delete();

        return redirect()->route('admin.clients.index')->with('success', 'Client deleted successfully');
    }
}
