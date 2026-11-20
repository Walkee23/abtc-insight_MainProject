<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Support\Audit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;   // NEW
use Illuminate\Support\Str;                   // NEW

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // 1. Check if the user filled in both fields
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

         // NEW: lockout check (5 failed attempts per username + IP)
        $throttleKey = Str::lower($request->input('username')) . '|' . $request->ip();

        // 2. Attempt to log them in
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // 3. Get the user's role from the database
            $role = Auth::user()->role;
            Audit::log('login', "Signed in as {$role}");

            // 4. Send them to the correct dashboard based on their role
            if ($role === 'Admin') {
                return redirect()->intended('/admin/dashboard');
            } elseif ($role === 'Staff') {
                return redirect()->intended('/staff/dashboard');
            } elseif ($role === 'Health Worker') {
                return redirect()->intended('/healthworker/dashboard');
            } elseif ($role === 'BHW') {
                return redirect()->intended('/bhw/dashboard');
            } elseif ($role === 'IT') {
                return redirect()->intended('/it/dashboard');
            } else {
                // Default fallback if role is missing
                return redirect('/');
            }
        }

         // NEW: count this failed attempt (lock window = 300 seconds = 5 minutes)
        RateLimiter::hit($throttleKey, 300);

        // 5. If it fails, send them back with an error
        Audit::log('login_failed', "Failed sign-in attempt for username '{$request->input('username')}'", $request->input('username'));

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username'); 
    }

    public function logout(Request $request)
    {
        Audit::log('logout', 'Signed out');
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Every role (Admin, Staff, Health Worker, BHW) lands back on the login page
        return redirect()->route('login');
    }
}
