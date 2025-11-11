<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnnouncementController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssignmentController;

// Public routes
Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected routes (require login)
Route::middleware('auth')->group(function () {
    // Dashboards
    Route::get('/student', [DashboardController::class, 'student'])->name('student.dashboard');
    Route::get('/lecturer', [DashboardController::class, 'lecturer'])->name('lecturer.dashboard');
    Route::get('/admin', [DashboardController::class, 'admin'])->name('admin.dashboard');
    
    // Announcements
    Route::resource('announcements', AnnouncementController::class)->except(['edit', 'update']);

    // Assignments Routes
Route::resource('assignments', AssignmentController::class);
Route::post('/assignments/{assignment}/submit', [AssignmentController::class, 'submit'])->name('assignments.submit');
Route::post('/submissions/{submission}/grade', [AssignmentController::class, 'grade'])->name('submissions.grade');
// Assignment submissions route
Route::get('assignments/{assignment}/submissions', [AssignmentController::class, 'submissions'])->name('assignments.submissions');
});