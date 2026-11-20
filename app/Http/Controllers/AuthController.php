<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Support\Audit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user()->role);
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        $throttleKey = Str::lower($request->input('username')) . '|' . $request->ip();

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $request->session()->forget('url.intended'); // Clear any stale intended URL

            $role = Auth::user()->role;
            Audit::log('login', "Signed in as {$role}");

            return $this->redirectByRole($role);
        }

        RateLimiter::hit($throttleKey, 300);

        Audit::log('login_failed', "Failed sign-in attempt for username '{$request->input('username')}'", $request->input('username'));

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Audit::log('logout', 'Signed out');
        Auth::logout();

        $request->session()->forget('url.intended');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $redirectTo = $request->input('redirect_to');
        if ($redirectTo && str_starts_with($redirectTo, '/')) {
            return redirect($redirectTo);
        }

        return redirect()->route('login');
    }

    private function redirectByRole(?string $role)
    {
        $url = match ($role) {
            'Admin'         => '/admin/dashboard',
            'Staff'         => '/staff/dashboard',
            'Health Worker' => '/healthworker/dashboard',
            'BHW'           => '/bhw/dashboard',
            'IT'            => '/it/dashboard',
            default         => '/',
        };

        return redirect($url);
    }
}
