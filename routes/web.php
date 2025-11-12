<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssignmentController;

// Public routes
Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/test-create', function() {
    return "Test route is working!";
});

Route::get('/test-create-view', function() {
    return view('assignments.create');
});

Route::get('/assignments/create', [App\Http\Controllers\AssignmentController::class, 'create'])->name('assignments.create.fix');

// Protected routes (require login)
Route::middleware('auth')->group(function () {
    // Dashboards - Each role can only access their own dashboard
    Route::get('/student', [DashboardController::class, 'student'])->name('student.dashboard')->middleware('role:student');
    Route::get('/lecturer', [DashboardController::class, 'lecturer'])->name('lecturer.dashboard')->middleware('role:lecturer');
    Route::get('/admin', [DashboardController::class, 'admin'])->name('admin.dashboard')->middleware('role:admin');
    
    // Announcements - Accessible by all authenticated users
    Route::resource('announcements', AnnouncementController::class)->except(['edit', 'update']);

    // ==================== ASSIGNMENT ROUTES WITH ROLE PROTECTION ====================
    
    // Assignment viewing and listing - Accessible by all roles
    Route::get('/assignments', [AssignmentController::class, 'index'])->name('assignments.index');
    Route::get('/assignments/{assignment}', [AssignmentController::class, 'show'])->name('assignments.show');

    // Assignment creation/management - Only lecturers and admins
    Route::middleware(['role:lecturer,admin'])->group(function () {
        // Assignment CRUD routes
        Route::get('/assignments/create', [AssignmentController::class, 'create'])->name('assignments.create');
        Route::post('/assignments', [AssignmentController::class, 'store'])->name('assignments.store');
        Route::get('/assignments/{assignment}/edit', [AssignmentController::class, 'edit'])->name('assignments.edit');
        Route::put('/assignments/{assignment}', [AssignmentController::class, 'update'])->name('assignments.update');
        Route::delete('/assignments/{assignment}', [AssignmentController::class, 'destroy'])->name('assignments.destroy');
        
        // Submission management routes
        Route::get('/assignments/{assignment}/submissions', [AssignmentController::class, 'submissions'])->name('assignments.submissions');
        Route::post('/submissions/{submission}/grade', [AssignmentController::class, 'grade'])->name('submissions.grade');
        Route::get('/submissions/{submission}/download', [AssignmentController::class, 'download'])->name('submissions.download');
        
        // Grading routes
        Route::get('/assignments/{assignment}/grading-dashboard', [AssignmentController::class, 'gradingDashboard'])->name('grading.dashboard');
        Route::post('/assignments/{assignment}/bulk-grade', [AssignmentController::class, 'bulkGrade'])->name('grading.bulk');
        Route::get('/assignments/{assignment}/export-grades', [AssignmentController::class, 'exportGrades'])->name('grading.export');
    });

    // Assignment submission - Only for students
    Route::middleware(['role:student'])->group(function () {
        Route::post('/assignments/{assignment}/submit', [AssignmentController::class, 'submit'])->name('assignments.submit');
    });

    // ==================== ADMIN ROUTES WITH ADMIN-ONLY PROTECTION ====================
    Route::prefix('admin')->middleware(['role:admin'])->group(function () {
        // Admin Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        
        // User Management
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        Route::post('/users/{user}/update-role', [AdminController::class, 'updateUserRole'])->name('admin.users.update-role');
        Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
        
        // Subject Management
        Route::get('/subjects', [AdminController::class, 'subjects'])->name('admin.subjects');
        Route::post('/subjects', [AdminController::class, 'storeSubject'])->name('admin.subjects.store');
        Route::put('/subjects/{subject}', [AdminController::class, 'updateSubject'])->name('admin.subjects.update');
        Route::delete('/subjects/{subject}', [AdminController::class, 'deleteSubject'])->name('admin.subjects.delete');
        
        // System Settings
        Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
        Route::post('/settings', [AdminController::class, 'updateSettings'])->name('admin.settings.update');
        
        // Analytics
        Route::get('/analytics', [AdminController::class, 'analytics'])->name('admin.analytics');
        
        // Backup
        Route::get('/backup', [AdminController::class, 'backup'])->name('admin.backup');
        Route::post('/backup/create', [AdminController::class, 'createBackup'])->name('admin.backup.create');
        
        // Activity Logs
        Route::get('/activity-logs', [AdminController::class, 'activityLogs'])->name('admin.activity-logs');
    });
});