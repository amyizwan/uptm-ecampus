<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    // Show all announcements
public function index()
{
    $user = Auth::user();

    // All announcements (for display)
    $announcements = Announcement::with('user')->orderBy('created_at', 'desc')->get();

    // Lecturer-specific metrics
    $myAnnouncementsCount = Announcement::where('user_id', $user->id)->count();
    $myAssignmentsCount = \App\Models\Assignment::where('lecturer_id', $user->id)->count();
    $subjects = Subject::where('lecturer_id', $user->id)->get();
    $subjectsCount = $subjects->count();
    $recentAnnouncements = Announcement::where('user_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->take(3)
        ->get();

    return view('announcements.indexlect', compact(
        'announcements',
        'myAnnouncementsCount',
        'myAssignmentsCount',
        'subjectsCount',
        'recentAnnouncements'
    ));
}


    // Show create form (for admins only)
    public function create()
    {
        // Only allow admin access
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'lecturer') {
            abort(403, 'Unauthorized action.');
        }

        if (Auth::user()->role === 'admin') {
            $subjects = Subject::all();
        } else {
            $subjects = Auth::user()->taughtSubjects; // Make sure this relationship exists
        }
    
        return view('announcements.create', compact('subjects'));
    }

    // Store new announcement
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'subject_id' => 'nullable|exists:subjects,id',
        ]);

        Announcement::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id(),
            'subject_id' => $request->subject_id,
        ]);

        return redirect()->route('announcements.index')
            ->with('success', 'Announcement created successfully!');
    }

    // Delete announcement
    public function destroy(Announcement $announcement)
    {
        if (Auth::user()->role !== 'admin'  && Auth::user()->role !== 'lecturer') {
            abort(403, 'Unauthorized action.');
        }

        $announcement->delete();
        return redirect()->route('announcements.index')
            ->with('success', 'Announcement deleted successfully!');
    }
}