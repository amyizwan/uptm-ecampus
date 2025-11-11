<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Announcement;
use App\Models\Assignment;
use App\Models\Grade;
use App\Models\Attendance;
use App\Models\Document;

class DashboardController extends Controller
{
    public function student()
    {
        // Get the logged-in user
        $user = Auth::user();
        
        // If no user is logged in, use dummy data for testing
        if (!$user) {
            $user = (object)[
                'name' => 'Nur Amymelinda',
                'role' => 'student',
                'student_id' => 'AM2311015254',
                'email' => 'student@uptm.edu.my',
                'id' => 1
            ];
        }

        // Get real data from database
        $announcementsCount = Announcement::count();
        $pendingAssignmentsCount = Assignment::count();
        $grades = Grade::where('student_id', $user->id)->get();
        $attendance = Attendance::where('student_id', $user->id)->get();
        $documents = Document::all();
        
        // Calculate GPA (simplified)
        if ($grades->count() > 0) {
            $averageMarks = $grades->avg('marks');
            $gpa = number_format(($averageMarks / 100) * 4.0, 2);
        } else {
            $gpa = '-';
        }
        
        // Calculate attendance percentage
        $totalClasses = $attendance->count();
        $presentClasses = $attendance->where('status', 'present')->count();
        $attendancePercentage = $totalClasses > 0 ? round(($presentClasses / $totalClasses) * 100) : 0;

        return view('dashboard.student', compact(
            'user', 
            'announcementsCount', 
            'pendingAssignmentsCount',
            'grades',
            'attendance',
            'documents',
            'gpa',
            'attendancePercentage'
        ));
    }
    
    public function lecturer()
{
    $user = Auth::user();
    
    // If no user is logged in, use dummy data for testing
    if (!$user) {
        $user = (object)[
            'name' => 'Dr. Lecturer',
            'role' => 'lecturer',
            'email' => 'lecturer@uptm.edu.my',
            'id' => 2
        ];
    }

    // Get real data for lecturer
    $myAnnouncementsCount = \App\Models\Announcement::where('user_id', $user->id)->count();
    $myAssignmentsCount = \App\Models\Assignment::where('lecturer_id', $user->id)->count();
    $subjects = \App\Models\Subject::where('lecturer_id', $user->id)->get();
    $subjectsCount = $subjects->count();
    $pendingGradingCount = 0; // You can add submission counting logic later
    $recentAnnouncements = \App\Models\Announcement::where('user_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->take(3)
        ->get();

    return view('dashboard.lecturer', compact(
        'user',
        'myAnnouncementsCount',
        'myAssignmentsCount',
        'subjects',
        'subjectsCount',
        'pendingGradingCount',
        'recentAnnouncements'
    ));
}
    
    public function admin()
    {
        $user = Auth::user();
        
        if (!$user) {
            $user = (object)[
                'name' => 'System Administrator', 
                'role' => 'admin',
                'email' => 'admin@uptm.edu.my'
            ];
        }
        
        return view('dashboard.admin', compact('user'));
    }
}