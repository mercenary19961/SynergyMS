<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    public function index()
    {
        $clients = Client::with('user')->paginate(10);
        return view('admin.clients.index', compact('clients'));
    }
    
    public function show($id)
    {
        $client = Client::with(['user', 'projects'])->findOrFail($id);
        return view('admin.clients.show', compact('client'));
    }

    public function create()
    {
        $users = User::all();
        return view('admin.clients.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'company_name' => 'required|string|max:255',
            'industry' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
        ]);

        Client::create($request->all());

        return redirect()->route('admin.clients.index')->with('success', 'Client added successfully');
    }

    public function edit(Client $client)
    {
        $users = User::all();
        return view('admin.clients.edit', compact('client', 'users'));
    }

    public function update(Request $request, Client $client)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'company_name' => 'required|string|max:255',
            'industry' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
        ]);

        $client->update($request->all());

        return redirect()->route('admin.clients.index')->with('success', 'Client updated successfully');
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('admin.clients.index')->with('success', 'Client deleted successfully');
    }
}
