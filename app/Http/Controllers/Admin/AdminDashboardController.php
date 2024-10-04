<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Ticket;


class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();

        $recentTickets = Ticket::latest()->limit(5)->get(); 

        return view('dashboard.admin.index', compact('totalUsers', 'recentTickets'));
    }
}
