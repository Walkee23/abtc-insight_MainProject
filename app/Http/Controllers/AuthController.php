<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // 1. Check if the user filled in both fields
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        // 2. Attempt to log them in
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // 3. Get the user's role from the database
            $role = Auth::user()->role;
            
            // 4. Send them to the correct dashboard based on their role
            if ($role === 'Admin') {
                return redirect()->intended('/admin/dashboard');
            } elseif ($role === 'Staff') {
                return redirect()->intended('/staff/dashboard');
            } elseif ($role === 'Health Worker') {
                return redirect()->intended('/healthworker/dashboard');
            } elseif ($role === 'BHW') {
                return redirect()->intended('/bhw/dashboard');
            } else {
                // Default fallback if role is missing
                return redirect('/');
            }
        }

        // 5. If it fails, send them back with an error
        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ]);
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}