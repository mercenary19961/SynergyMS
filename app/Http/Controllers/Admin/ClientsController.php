<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClientsController extends Controller
{
    public function index(Request $request)
    {
        // Start with a base query to fetch clients with their associated user
        $query = Client::with('user');
    
        // Filter by Client Name
        if ($request->has('name') && $request->name != '') {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%');
            });
        }
    
        // Filter by Company Name
        if ($request->has('company_name') && $request->company_name != '') {
            $query->where('company_name', 'like', '%' . $request->company_name . '%');
        }
    
        // Filter by Industry
        if ($request->has('industry') && $request->industry != '') {
            $query->where('industry', 'like', '%' . $request->industry . '%');
        }
    
        // Paginate the results
        $clients = $query->paginate(8);
    
        // Return the view with the filtered clients
        return view('admin.clients.index', compact('clients'));
    }

    public function show($id)
    {
        $client = Client::with(['user', 'projects'])->findOrFail($id);
        return view('admin.clients.show', compact('client'));
    }

    public function create()
    {
        return view('admin.clients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_name' => 'required|string|max:255',
            'user_email' => 'required|email|unique:users,email',
            'user_password' => 'required|string|min:6',
            'gender' => 'nullable|in:Male,Female',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'company_name' => 'required|string|max:255',
            'industry' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
        ]);

        try {
            $image = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image')->store('clients', 'public');
            }

            DB::transaction(function () use ($request, $image) {
                $user = User::create([
                    'name' => $request->input('user_name'),
                    'email' => $request->input('user_email'),
                    'password' => Hash::make($request->input('user_password')),
                    'gender' => $request->input('gender'),
                    'image' => $image,
                ]);

                $user->assignRole('Client');

                Client::create([
                    'user_id' => $user->id,
                    'company_name' => $request->input('company_name'),
                    'industry' => $request->input('industry'),
                    'contact_number' => $request->input('contact_number'),
                    'address' => $request->input('address'),
                    'website' => $request->input('website'),
                ]);
            });

            Log::info('Client created successfully', ['email' => $request->input('user_email')]);

            return redirect()->route('admin.clients.index')->with('success', 'Client added successfully');
        } catch (\Exception $e) {
            Log::error('Failed to create client', [
                'email' => $request->input('user_email'),
                'error' => $e->getMessage()
            ]);

            return redirect()->back()->withInput()->with('error', 'Failed to create client. Please try again.');
        }
    }

    public function edit($id)
    {
        $client = Client::with('user')->findOrFail($id);
        return view('admin.clients.edit', compact('client'));
    }
    

    public function update(Request $request, Client $client)
    {
        // Validate the update fields for both user and client
        $request->validate([
            'user_name' => 'required|string|max:255',
            'user_email' => 'required|email|unique:users,email,' . $client->user_id, // Allow the current user's email
            'user_password' => 'nullable|string|min:6|confirmed', 
            'gender' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'company_name' => 'required|string|max:255',
            'industry' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
        ]);
    
        // Handle profile image upload if a new image is uploaded
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('clients', 'public');
            $client->user->image = $image;
        }
    
        // Update the user information
        $client->user->name = $request->input('user_name');
        $client->user->email = $request->input('user_email');
        $client->user->gender = $request->input('gender');
    
        // If a new password is provided, update it
        if ($request->filled('user_password')) {
            $client->user->password = Hash::make($request->input('user_password'));
        }
    
        // Save the updated user information
        $client->user->save();
    
        // Update the client information
        $client->update([
            'company_name' => $request->input('company_name'),
            'industry' => $request->input('industry'),
            'contact_number' => $request->input('contact_number'),
            'address' => $request->input('address'),
            'website' => $request->input('website'),
        ]);
    
        return redirect()->route('admin.clients.index')->with('success', 'Client updated successfully');
    }
    

    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('admin.clients.index')->with('success', 'Client deleted successfully');
    }
}
