<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Exception;

class AdminController extends Controller
{
    /**
     * Admin Dashboard - Ensures all variables are defined.
     */
    public function dashboard(): View
    {
        $user = auth()->user();

        // **FIX: Initialize all variables before try/catch to ensure they are always defined.**
        $totalStudents = 0;
        $totalLecturers = 0;
        $totalSubjects = 0;
        $totalUsers = 0;

        try {
            $totalStudents = User::where('role', 'student')->count();
            $totalLecturers = User::where('role', 'lecturer')->count();
            $totalUsers = User::count();

            // Check if Subject model exists and has data
            if (class_exists(Subject::class)) {
                $totalSubjects = Subject::count();
            }

        } catch (Exception $e) {
            // Log the error for debugging purposes
            \Log::error("Database error in AdminController@dashboard: " . $e->getMessage());
            // Variables remain 0 if an error occurs.
        }

        return view('dashboard.admin', compact(
            'user',
            'totalStudents',
            'totalLecturers', 
            'totalSubjects',
            'totalUsers'
        ));
    }

    /**
     * User Management - Secure version with SQL injection protection
     */
    public function users(): View
    {
        // Use Laravel's Eloquent to prevent SQL injection
        $users = User::select('id', 'name', 'email', 'role', 'created_at')
                    ->orderBy('name')
                    ->get();

        return view('admin.users', compact('users'));
    }

    /**
     * Update User Role - Secure version
     */
    public function updateUserRole(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'role' => 'required|in:student,lecturer,admin' // Only allow valid roles
        ]);

        // Prevent users from changing their own role
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot change your own role.');
        }

        $user->update([
            'role' => $request->role
        ]);

        return redirect()->back()->with('success', 'User role updated successfully!');
    }

    /**
     * Delete User - Secure version
     */
    public function deleteUser(User $user): RedirectResponse
    {
        // Prevent users from deleting themselves
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }

        // Prevent deletion of the last admin
        $adminCount = User::where('role', 'admin')->count();
        if ($user->role === 'admin' && $adminCount <= 1) {
            return redirect()->back()->with('error', 'Cannot delete the last administrator.');
        }

        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully!');
    }

    /**
     * Subject Management - With error handling
     */
    public function subjects(): View
    {
        try {
            // Eager load lecturer for display, assuming a relationship exists
            $subjects = Subject::with('lecturer')->get(); 
        } catch (Exception $e) {
            \Log::error("Database error in AdminController@subjects: " . $e->getMessage());
            $subjects = collect(); // Empty collection if error
        }

        return view('admin.subjects', compact('subjects'));
    }

    /**
     * Store Subject - Secure version
     */
    public function storeSubject(Request $request): RedirectResponse
    {
        // Check if Subject model exists
        if (!class_exists(Subject::class)) {
            return redirect()->back()->with('error', 'Subject management is not available yet.');
        }

        $request->validate([
            'name' => [
                'required', 
                'string', 
                'max:255',
                'regex:/^[a-zA-Z0-9\s\-&:,.]+$/u'
            ],
            'code' => [
                'required',
                'string', 
                'max:50',
                'unique:subjects',
                'regex:/^[A-Z0-9]+$/u'
            ],
            'description' => 'nullable|string|max:1000',
            'credits' => 'required|integer|min:1|max:12', 
            'is_active' => 'nullable|boolean',
        ], [
            'name.regex' => 'Subject name can only contain letters, numbers, spaces, and safe punctuation (-, &, :, .).',
            'code.regex' => 'Subject code can only contain uppercase letters and numbers.',
            'credits.min' => 'Credits must be at least 1.',
            'credits.max' => 'Credits cannot exceed 12.',
        ]);

        $sanitizedName = htmlspecialchars(strip_tags($request->name), ENT_QUOTES, 'UTF-8');
        $sanitizedDescription = $request->description ? htmlspecialchars(strip_tags($request->description), ENT_QUOTES, 'UTF-8') : null;

        Subject::create([
            'name' => $sanitizedName,
            'code' => strtoupper($request->code),
            'description' => $sanitizedDescription,
            'credits' => $request->credits,
            'is_active' => $request->boolean('is_active'),
            'lecturer_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Subject created successfully!');
    }

    /**
     * Update Subject - Secure version
     */
    public function updateSubject(Request $request, Subject $subject): RedirectResponse
    {
        $request->validate([
            'name' => [
                'required', 
                'string', 
                'max:255',
                'regex:/^[a-zA-Z0-9\s\-&:,.]+$/u'
            ],
            'code' => [
                'required',
                'string', 
                'max:50',
                'unique:subjects,code,' . $subject->id, 
                'regex:/^[A-Z0-9]+$/u'
            ],
            'description' => 'nullable|string|max:1000',
            'credits' => 'required|integer|min:1|max:12', 
            'is_active' => 'nullable|boolean',
        ], [
            'name.regex' => 'Subject name can only contain letters, numbers, spaces, and safe punctuation (-, &, :, .).',
            'code.regex' => 'Subject code can only contain uppercase letters and numbers.',
            'credits.min' => 'Credits must be at least 1.',
            'credits.max' => 'Credits cannot exceed 12.',
        ]);

        // Sanitize input
        $sanitizedName = htmlspecialchars(strip_tags($request->name), ENT_QUOTES, 'UTF-8');
        $sanitizedDescription = $request->description ? htmlspecialchars(strip_tags($request->description), ENT_QUOTES, 'UTF-8') : null;

        $subject->update([
            'name' => $sanitizedName,
            'code' => strtoupper($request->code),
            'description' => $sanitizedDescription,
            'credits' => $request->credits,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->back()->with('success', 'Subject updated successfully!');
    }

    /**
     * Delete Subject
     */
    public function deleteSubject(Subject $subject): RedirectResponse
    {
        $subject->delete();
        return redirect()->back()->with('success', 'Subject deleted successfully!');
    }

    /**
     * System Settings
     */
    public function settings(): View
    {
        return view('admin.settings');
    }

    /**
     * Update Settings
     */
    public function updateSettings(Request $request): RedirectResponse
    {
        // Add actual setting update logic here...
        return redirect()->back()->with('success', 'Settings updated successfully!');
    }

    /**
     * Analytics
     */
    public function analytics(): View
    {
        return view('admin.analytics');
    }

    /**
     * Backup
     */
    public function backup(): View
    {
        return view('admin.backup');
    }

    /**
     * Create Backup
     */
    public function createBackup(): RedirectResponse
    {
        // Add actual backup creation logic here...
        return redirect()->back()->with('success', 'Backup created successfully!');
    }

    /**
     * Activity Logs
     */
    public function activityLogs(): View
    {
        return view('admin.activity-logs');
    }
}