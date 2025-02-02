<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StudentController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

// Public routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::post('/role/redirect', [RoleController::class, 'redirect'])->name('role.redirect');

// Guest routes (only accessible if NOT logged in)
Route::middleware('guest')->group(function () {
    Route::get('/student', function () {
        return view('student');
    })->name('student');
    
    Route::post('/student/store', [StudentController::class, 'store'])->name('student.store');
});

// Role-specific routes (publicly accessible)
Route::get('/teacher', function () {
    return view('teacher');
})->name('teacher');

Route::get('/admin', function () {
    return view('admin');
})->name('admin');

Route::get('/developer', function () {
    return view('developer');
})->name('developer');

// Protected routes that require authentication
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
    // Add other protected routes here
});

// Authentication routes
Auth::routes(['verify' => true]);

// Email verification routes
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');