<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login', ['hideHeader' => true]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            /**
             * @method bool hasRole(string $role) // PHPDoc to let Intelephense know hasRole() exists
             */
            $user = Auth::user();
    

            // Redirect based on role
            if ($user->hasRole('Super Admin')) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->hasRole('Client')) {
                return redirect()->route('client.dashboard');
            } elseif ($user->hasRole('Project Manager')) {
                return redirect()->route('project-manager.dashboard');
            } elseif ($user->hasRole('HR')) {
                return redirect()->route('hr.dashboard');
            } elseif ($user->hasRole('Employee')) {
                return redirect()->route('employee.dashboard');
            } else {
                return redirect()->route('login');
            }
        }
    
        // If authentication fails
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
    

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }
}
