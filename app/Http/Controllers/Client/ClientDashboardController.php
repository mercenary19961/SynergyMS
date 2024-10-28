<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Invoice;
use App\Models\Ticket;
use App\Models\Department;
use App\Models\Project;

class ClientDashboardController extends Controller
{
    public function index()
    {
        $client = Auth::user()->client;
        
        if (!$client) {
            abort(403, 'Unauthorized');
        }

        $userId = Auth::id();
        
        // Get the latest 4 projects for the client
        $clientProjects = $client->projects()->with('projectManager', 'taskEmployees')->latest()->take(4)->get();
        
        // Get the latest 5 tickets for the client
        $clientTickets = Ticket::where('user_id', $userId)->latest()->take(4)->get();
        
        // Get the unpaid and paid invoices count
        $clientInvoices = Invoice::where('user_id', $userId)->latest()->take(5)->get();
        $totalUnpaidInvoices = Invoice::where('user_id', $userId)->where('status', 'unpaid')->sum('amount');
        $unpaidInvoicesCount = Invoice::where('user_id', $userId)->where('status', 'unpaid')->count();
        $totalPaidInvoices = Invoice::where('user_id', $userId)->where('status', 'paid')->sum('amount');
        $paidInvoicesCount = Invoice::where('user_id', $userId)->where('status', 'paid')->count();
        
        // Get notifications
        $clientNotifications = Auth::user()->notifications()->latest()->take(5)->get();

        // Get all departments
        $departments = Department::where('sector', 'Projects')->get();

        // Pass the data to the view
        return view('pages.client.clientDashboard', compact(
            'client', 'clientProjects', 'clientTickets', 'clientInvoices', 
            'clientNotifications', 'totalUnpaidInvoices', 'totalPaidInvoices',
            'unpaidInvoicesCount', 'paidInvoicesCount', 'departments'
        ));
    }
}
