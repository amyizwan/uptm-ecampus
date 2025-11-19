<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnnouncementController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\UserController;

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

Route::get('/assignments/lecturer', [AssignmentController::class, 'index'])
    ->name('assignments.indexlect');

});

Route::get('/assignments/lecturer', [AssignmentController::class, 'index'])
    ->name('assignments.indexlect');

// Show grading form
Route::get('/assignments/{assignment}/submissions/{submission}/grade', [AssignmentController::class, 'grade'])
    ->name('assignments.grade');

// Save grade
Route::post('/assignments/{assignment}/submissions/{submission}/grade', [AssignmentController::class, 'storeGrade'])
    ->name('assignments.grade.store');


Route::get('/subjects/{id}', [AssignmentController::class, 'showSubject'])
    ->name('subjects.show');

    Route::get('/subjects/{id}/students', [AssignmentController::class, 'showStudents'])
    ->name('subjects.students');

Route::get('/profile/edit', [UserController::class, 'edit'])->name('profile.edit');
Route::post('/profile/update', [UserController::class, 'update'])->name('profile.update');
    
Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/student/profile/edit', [DashboardController::class, 'editProfile'])->name('student.profile.edit');
    Route::post('/student/profile/update', [DashboardController::class, 'updateProfile'])->name('student.profile.update');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/student/announcements', [DashboardController::class, 'studentAnnouncements'])
        ->name('student.announcements.index');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/users', [DashboardController::class, 'adminUsers'])->name('admin.users');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/users', [DashboardController::class, 'adminUsers'])->name('admin.users');
    Route::post('/admin/users/store', [DashboardController::class, 'storeUser'])->name('admin.users.store');
    Route::delete('/admin/users/{id}', [DashboardController::class, 'deleteUser'])->name('admin.users.delete');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/subjects', [DashboardController::class, 'adminSubjects'])->name('admin.subjects');
    Route::post('/admin/subjects/store', [DashboardController::class, 'storeSubject'])->name('admin.subjects.store');
    Route::delete('/admin/subjects/{id}', [DashboardController::class, 'deleteSubject'])->name('admin.subjects.delete');
    Route::post('/admin/subjects/{id}/update-lecturer', [DashboardController::class, 'updateLecturer'])->name('admin.subjects.updateLecturer');

});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/announcements', [DashboardController::class, 'adminAnnouncements'])->name('admin.announcements');
    Route::post('/admin/announcements/store', [DashboardController::class, 'storeAnnouncement'])->name('admin.announcements.store');
    Route::delete('/admin/announcements/{id}', [DashboardController::class, 'deleteAnnouncement'])->name('admin.announcements.delete');
});

Route::get('/admin', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');

// Student download submission
Route::get('/assignments/{assignment}/download/{submission}', [AssignmentController::class, 'download'])
    ->name('assignments.download');

    // Lecturer/Admin download any submission
Route::get('/submissions/{submission}/download', [AssignmentController::class, 'downloadSubmission'])
    ->name('submissions.download');

    // Lecturer/Admin download submission from grading page
Route::get('/grades/submission/{submission}/download', [AssignmentController::class, 'downloadGradeSubmission'])
    ->name('grades.submission.download');
Route::get('/submissions/{submission}/download', [AssignmentController::class, 'downloadSubmissionFile'])
    ->name('submissions.download');
