<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome_portal');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// Role Dashboards
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
});

Route::get('/staff/dashboard', function () {
    return view('staff.dashboard');
});

Route::get('/healthworker/dashboard', function () {
    return view('healthworker.dashboard');
});

Route::get('/bhw/dashboard', function () {
    return view('bhw.dashboard');
});

Route::get('/patient/register', function () {
    return view('patient.New_Record_Registration');
})->name('patient.register');

Route::get('/patient/tracking-portal', function () {
    return view('patient.Tracking_Portal');
})->name('patient.tracking.portal');

