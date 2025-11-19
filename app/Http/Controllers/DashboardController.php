<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Announcement;
use App\Models\Assignment;
use App\Models\Grade;
use App\Models\Attendance;
use App\Models\Document;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
public function adminDashboard()
{
    $totalStudents = User::where('role', 'student')->count();
    $totalLecturers = User::where('role', 'lecturer')->count();
    $activeSubjects = Subject::count();
    $user = auth()->user();

    return view('dashboard.admin', compact('totalStudents', 'totalLecturers', 'activeSubjects', 'user'));
}
public function adminAnnouncements()
{
    // Get announcements with related user + subject
    $announcements = Announcement::with(['user', 'subject'])->latest()->get();

    // Get all subjects for dropdown
    $subjects = Subject::all();

    return view('manageannouncement.index', compact('announcements', 'subjects'));
}

public function storeAnnouncement(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
    ]);

    Announcement::create([
        'title' => $request->title,
        'content' => $request->content,
        'user_id' => auth()->id(), 
    ]);

    return redirect()->route('admin.announcements')->with('success', 'Announcement created successfully.');
}

public function deleteAnnouncement($id)
{
    $announcement = Announcement::findOrFail($id);
    $announcement->delete();

    return redirect()->route('admin.announcements')->with('success', 'Announcement deleted successfully.');
}
public function adminSubjects(Request $request)
{
    $search = $request->get('search');

    $subjects = Subject::with('lecturer') // eager load lecturer
        ->when($search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
        })
        ->get();

    // get all lecturers for dropdown
    $lecturers = User::where('role', 'lecturer')->get();

    return view('managesubject.index', compact('subjects', 'search', 'lecturers'));
}



public function storeSubject(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'code' => 'required|string|max:50|unique:subjects,code',
        'lecturer_id' => 'required|exists:users,id',
    ]);

    Subject::create([
        'name' => $request->name,
        'code' => $request->code,
        'lecturer_id' => $request->lecturer_id,
    ]);

    return redirect()->route('admin.subjects')->with('success', 'Subject added successfully.');
}


public function deleteSubject($id)
{
    $subject = Subject::findOrFail($id);
    $subject->delete();

    return redirect()->route('admin.subjects')->with('success', 'Subject deleted successfully.');
}
public function adminUsers(Request $request)
{
    // Filter by role if provided
    $role = $request->get('role');
    $users = $role ? User::where('role', $role)->get() : User::all();

    return view('managezuser.index', compact('users', 'role'));
}

public function storeUser(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6',
        'role' => 'required|in:student,lecturer,admin',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
    ]);

    return redirect()->route('admin.users')->with('success', 'User added successfully.');
}

public function deleteUser($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
}

// public function adminSubjects()
// {
//     $subjects = Subject::all();
//     return view('admin.subjects.index', compact('subjects'));
// }

// public function adminAnnouncements()
// {
//     $announcements = Announcement::all();
//     return view('admin.announcements.index', compact('announcements'));
// }
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
    public function editProfile()
{
    $user = Auth::user();
    return view('profile.editstudent', compact('user'));
}
public function updateLecturer(Request $request, $id)
{
    $request->validate([
        'lecturer_id' => 'required|exists:users,id',
    ]);

    $subject = Subject::findOrFail($id);
    $subject->lecturer_id = $request->lecturer_id;
    $subject->save();

    return redirect()->route('admin.subjects')->with('success', 'Lecturer updated successfully.');
}

public function updateProfile(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'student_id' => 'nullable|string|max:50',
    ]);

    $user->update($request->only('name', 'email', 'student_id'));

    return redirect()->route('student.profile.edit')->with('success', 'Profile updated successfully.');
}
public function studentAnnouncements()
{
    $announcements = Announcement::with('subject')
        ->latest()
        ->get();

    return view('announcements.indexstudent', compact('announcements'));
}

}