<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\AssignmentSubmission;


class AssignmentController extends Controller
{
    public function downloadSubmissionFile($submissionId)
{
    $submission = AssignmentSubmission::findOrFail($submissionId);

    $filePath = $submission->file_path;

    if (Storage::disk('public')->exists($filePath)) {
        return Storage::disk('public')->download($filePath);
    }

    return back()->with('error', 'File not found.');
}

    public function downloadGradeSubmission($submissionId)
{
    // Find submission by ID
    $submission = AssignmentSubmission::findOrFail($submissionId);

    $filePath = $submission->file_path;

    if (Storage::disk('public')->exists($filePath)) {
        // Force download
        return Storage::disk('public')->download($filePath);
    }

    return back()->with('error', 'File not found.');
}
    public function downloadSubmission($submissionId)
{
    // Find submission by ID
    $submission = AssignmentSubmission::findOrFail($submissionId);

    $filePath = $submission->file_path;

    if (Storage::disk('public')->exists($filePath)) {
        // Force download
        return Storage::disk('public')->download($filePath);
    }

    return back()->with('error', 'File not found.');
}
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'lecturer') {
            // Lecturers only see their own assignments with submission counts
            $assignments = Assignment::with(['subject', 'lecturer'])
                ->withCount('submissions')
                ->where('lecturer_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // Students and admins see all assignments
            $assignments = Assignment::with(['subject', 'lecturer'])
                ->orderBy('created_at', 'desc')
                ->get();
        }
        
        return view('assignments.index', compact('assignments'));
    }

public function create()
{
    if (Auth::user()->role !== 'lecturer' && Auth::user()->role !== 'admin') {
        abort(403, 'Unauthorized action.');
    }

    $subjects = \App\Models\Subject::where('lecturer_id', Auth::id())->get();
    return view('assignments.create', compact('subjects'));
}


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date',
            'max_marks' => 'required|integer|min:1',
            'subject_id' => 'nullable|exists:subjects,id',
        ]);

        Assignment::create([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'max_marks' => $request->max_marks,
            'subject_id' => $request->subject_id,
            'lecturer_id' => Auth::id(),
            
        ]);

        return redirect()->route('assignments.index')
            ->with('success', 'Assignment created successfully!');
    }

    public function show(Assignment $assignment)
    {
        $assignment->load('subject', 'lecturer');
        return view('assignments.show', compact('assignment'));
    }

    public function download($assignmentId, $submissionId)
{
    // Ensure student can only download their own submission
    $submission = AssignmentSubmission::where('assignment_id', $assignmentId)
        ->where('id', $submissionId)
        ->where('student_id', auth()->id())
        ->firstOrFail();

    $filePath = $submission->file_path;

    if (Storage::disk('public')->exists($filePath)) {
        // Force download
        return Storage::disk('public')->download($filePath);
    }

    return back()->with('error', 'File not found.');
}

    // SUBMIT METHOD - FIXED FOR lecturer_id
    public function submit(Request $request, Assignment $assignment)
    {
        // Only students can submit assignments
        if (Auth::user()->role !== 'student') {
            return back()->with('error', 'Only students can submit assignments.');
        }

        $request->validate([
            'submission_file' => 'required|file|mimes:pdf,doc,docx,txt,zip|max:10240',
            'comments' => 'nullable|string|max:500',
        ]);

        // Check if file exists
        if (!$request->hasFile('submission_file')) {
            return back()->with('error', 'No file was uploaded. Please select a file.');
        }

        $file = $request->file('submission_file');
        
        // Check if file is valid
        if (!$file->isValid()) {
            return back()->with('error', 'File upload failed: ' . $file->getErrorMessage());
        }

        try {
            // Store the file
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('submissions', $fileName, 'public');
            
            // Create submission record
            \App\Models\AssignmentSubmission::create([
                'assignment_id' => $assignment->id,
                'student_id' => Auth::id(),
                'file_path' => $filePath,
                'comments' => $request->comments,
                'submitted_at' => now(),
            ]);

            return redirect()->route('assignments.show', $assignment)
                ->with('success', "Assignment submitted successfully!");

        } catch (\Exception $e) {
            return back()->with('error', 'File upload failed: ' . $e->getMessage());
        }
    }

    // View submissions for an assignment
    public function submissions(Assignment $assignment)
    {
        // Only lecturer who created the assignment or admin can view submissions
        if ($assignment->lecturer_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        // Load assignment with relationships and submissions
        $assignment->load(['subject', 'lecturer', 'submissions.student']);
        
        return view('assignments.submission', compact('assignment'));

    }

    public function grade(Assignment $assignment, \App\Models\AssignmentSubmission $submission)
{
    // Only lecturer who created the assignment or admin can grade
    if ($assignment->lecturer_id !== Auth::id() && Auth::user()->role !== 'admin') {
        abort(403, 'Unauthorized action.');
    }

    return view('assignments.grade', compact('assignment', 'submission'));
}
public function showSubject($id)
{
    // Fetch subject by ID
    $subject = Subject::findOrFail($id);

    // Pass it to a view
    return view('assignments.subject', compact('subject'));
}
public function showStudents($id)
{
    $subject = Subject::with('students')->findOrFail($id);
    return view('assignments.students', compact('subject'));
}


public function storeGrade(Request $request, Assignment $assignment, \App\Models\AssignmentSubmission $submission)
{
    // Only lecturer who created the assignment or admin can grade
    if ($assignment->lecturer_id !== Auth::id() && Auth::user()->role !== 'admin') {
        abort(403, 'Unauthorized action.');
    }

    // Validate input
    $request->validate([
        'marks' => 'required|integer|min:0|max:' . $assignment->max_marks,
        'feedback' => 'nullable|string|max:500',
    ]);

    // Save grade
    $submission->update([
        'marks' => $request->marks,
        'feedback' => $request->feedback,
        'graded_at' => now(),
    ]);

    // ✅ Option A: redirect back to submissions list
    return redirect()->route('assignments.submissions', $assignment)
        ->with('success', 'Grade saved successfully!');
}



    public function edit(Assignment $assignment)
    {
        if ($assignment->lecturer_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $subjects = Subject::all();
        return view('assignments.edit', compact('assignment', 'subjects'));
    }

    public function update(Request $request, Assignment $assignment)
    {
        if ($assignment->lecturer_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date',
            'max_marks' => 'required|integer|min:1',
            'subject_id' => 'nullable|exists:subjects,id',
        ]);

        $assignment->update([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'max_marks' => $request->max_marks,
            'subject_id' => $request->subject_id,
            
        ]);

        if (Auth::user()->role === 'lecturer') {
    return redirect()->route('assignments.index')
        ->with('success', 'Assignment created successfully!');
}

return redirect()->route('assignments.index')
    ->with('success', 'Assignment created successfully!');

    }

    public function destroy(Assignment $assignment)
    {
        if ($assignment->lecturer_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $assignment->delete();

        if (Auth::user()->role === 'lecturer') {
    return redirect()->route('assignments.index')
        ->with('success', 'Assignment deleted successfully!');
}

return redirect()->route('assignments.index')
    ->with('success', 'Assignment deleted successfully!');

    }
}