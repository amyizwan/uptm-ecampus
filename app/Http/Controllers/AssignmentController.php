<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; // ADD THIS IMPORT

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        
        if ($user->role === 'lecturer') {
            $assignments = Assignment::with('subject')
                ->where('lecturer_id', $user->id)
                ->latest()
                ->get();
        } else {
            $assignments = Assignment::with('subject')
                ->latest()
                ->get();
        }

        return view('assignments.index', compact('assignments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('assignments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9\s\-_,.!;():&@]+$/u' // Only allow safe characters
            ],
            'description' => [
                'required',
                'string',
                'max:2000',
                function ($attribute, $value, $fail) {
                    // Check for potential XSS attacks
                    $dangerousPatterns = [
                        '/<script\b[^>]*>(.*?)<\/script>/is',
                        '/javascript:/i',
                        '/onclick=/i',
                        '/onload=/i',
                        '/onerror=/i',
                        '/vbscript:/i'
                    ];
                    
                    foreach ($dangerousPatterns as $pattern) {
                        if (preg_match($pattern, $value)) {
                            $fail('The ' . $attribute . ' contains potentially dangerous content.');
                            break;
                        }
                    }
                }
            ],
            'subject_id' => 'required|exists:subjects,id',
            'due_date' => 'required|date|after:now',
            'max_marks' => 'required|integer|min:1|max:1000',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ], [
            'title.regex' => 'Title can only contain letters, numbers, spaces, and basic punctuation.',
            'due_date.after' => 'Due date must be in the future.',
            'file.mimes' => 'Only PDF and Word documents are allowed.',
        ]);

        // Sanitize input before saving
        $validated['title'] = htmlspecialchars(strip_tags($validated['title']), ENT_QUOTES, 'UTF-8');
        $validated['description'] = htmlspecialchars(strip_tags($validated['description']), ENT_QUOTES, 'UTF-8');

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('assignments', 'public');
        }

        Assignment::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'subject_id' => $validated['subject_id'],
            'lecturer_id' => auth()->id(),
            'due_date' => $validated['due_date'],
            'max_marks' => $validated['max_marks'],
            
            
        ]);

        return redirect()->route('assignments.index')->with('success', 'Assignment created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Assignment $assignment)
    {
        $userSubmission = null;
        if (auth()->user()->role === 'student') {
            $userSubmission = AssignmentSubmission::where('assignment_id', $assignment->id)
                ->where('student_id', auth()->id())
                ->first();
        }

        return view('assignments.show', compact('assignment', 'userSubmission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Assignment $assignment)
    {
        return view('assignments.edit', compact('assignment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Assignment $assignment)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'subject_id' => 'required|exists:subjects,id',
            'due_date' => 'required|date',
            'max_marks' => 'required|numeric|min:1',
            'file' => 'nullable|file|max:10240',
        ]);

        $filePath = $assignment->file_path;
        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($filePath) {
                Storage::disk('public')->delete($filePath);
            }
            $filePath = $request->file('file')->store('assignments', 'public');
        }

        $assignment->update([
            'title' => $request->title,
            'description' => $request->description,
            'subject_id' => $request->subject_id,
            'due_date' => $request->due_date,
            'max_marks' => $request->max_marks,
            'file_path' => $filePath,
        ]);

        return redirect()->route('assignments.index')->with('success', 'Assignment updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Assignment $assignment)
    {
        if ($assignment->file_path) {
            Storage::disk('public')->delete($assignment->file_path);
        }

        $assignment->delete();

        return redirect()->route('assignments.index')->with('success', 'Assignment deleted successfully!');
    }

    /**
     * Submit assignment as student
     */
    public function submit(Request $request, Assignment $assignment)
    {
        $request->validate([
            'file' => [
                'required',
                'file',
                'max:10240', // 10MB max
                'mimes:pdf,doc,docx,txt,jpg,jpeg,png', // Allowed types
                function ($attribute, $value, $fail) {
                    // Check for malicious file extensions
                    $maliciousExtensions = ['php', 'exe', 'js', 'html', 'htm', 'bat', 'sh', 'cmd'];
                    $extension = strtolower($value->getClientOriginalExtension());
                    
                    if (in_array($extension, $maliciousExtensions)) {
                        $fail('The file type is not allowed for security reasons.');
                    }
                },
            ],
            'comments' => 'nullable|string|max:500',
        ]);

        // Generate secure filename
        $originalName = pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $request->file('file')->getClientOriginalExtension();
        $safeName = Str::slug($originalName) . '_' . time() . '.' . $extension;
        
        $filePath = $request->file('file')->storeAs('submissions', $safeName, 'public');

        AssignmentSubmission::create([
            'assignment_id' => $assignment->id,
            'student_id' => auth()->id(),
            'file_path' => $filePath,
            'comments' => $request->comments,
            'submitted_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Assignment submitted successfully!');
    }

    /**
     * VIEW SUBMISSIONS AS LECTURER
     */
    public function submissions($assignmentId)
    {
        $assignment = Assignment::with(['submissions.student'])->findOrFail($assignmentId);
        return view('submissions', compact('assignment'));
    }

    /**
     * GRADE SUBMISSION
     */
    public function grade(Request $request, $submissionId)
    {
        $submission = AssignmentSubmission::findOrFail($submissionId);
        
        $request->validate([
            'marks' => 'required|numeric|min:0|max:' . $submission->assignment->max_marks,
            'feedback' => 'nullable|string|max:500'
        ]);

        $submission->update([
            'marks' => $request->marks,
            'feedback' => $request->feedback,
            'graded_at' => now()
        ]);

        return redirect()->back()->with('success', 'Submission graded successfully!');
    }

    /**
     * DOWNLOAD SUBMISSION
     */
    public function download($submissionId)
    {
        $submission = AssignmentSubmission::findOrFail($submissionId);
        
        // Check if user is authorized to download this file
        $user = auth()->user();
        
        if ($user->role === 'student' && $submission->student_id !== $user->id) {
            abort(403, 'You can only download your own submissions.');
        }
        
        if (!Storage::disk('public')->exists($submission->file_path)) {
            return redirect()->back()->with('error', 'File not found.');
        }

        // Get file information for secure download
        $filePath = storage_path('app/public/' . $submission->file_path);
        $safeFilename = pathinfo($submission->file_path, PATHINFO_BASENAME);
        
        // Security headers for download
        $headers = [
            'Content-Type' => 'application/octet-stream', // Generic type
            'Content-Disposition' => 'attachment; filename="' . $safeFilename . '"',
            'X-Content-Type-Options' => 'nosniff',
        ];

        return response()->download($filePath, $safeFilename, $headers);
    }

    /**
     * Download assignment file (secure version)
     */
    public function downloadAssignmentFile($assignmentId)
    {
        $assignment = Assignment::findOrFail($assignmentId);
        
        if (!$assignment->file_path) {
            return redirect()->back()->with('error', 'No file attached to this assignment.');
        }

        if (!Storage::disk('public')->exists($assignment->file_path)) {
            return redirect()->back()->with('error', 'Assignment file not found.');
        }

        $filePath = storage_path('app/public/' . $assignment->file_path);
        $safeFilename = 'assignment_' . $assignment->id . '_' . pathinfo($assignment->file_path, PATHINFO_BASENAME);
        
        $headers = [
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename="' . $safeFilename . '"',
            'X-Content-Type-Options' => 'nosniff',
        ];

        return response()->download($filePath, $safeFilename, $headers);
    }

    /**
     * Grading Dashboard
     */
    public function gradingDashboard($assignmentId)
    {
        $assignment = Assignment::with(['submissions.student', 'subject'])
            ->findOrFail($assignmentId);

        // Grade statistics
        $totalSubmissions = $assignment->submissions->count();
        $gradedSubmissions = $assignment->submissions->whereNotNull('marks')->count();
        $pendingSubmissions = $totalSubmissions - $gradedSubmissions;
        
        // Average marks
        $averageMarks = $assignment->submissions->whereNotNull('marks')->avg('marks');
        $maxMarks = $assignment->max_marks;
        
        // Grade distribution
        $gradeDistribution = [
            'A' => $assignment->submissions->where('marks', '>=', $maxMarks * 0.8)->count(),
            'B' => $assignment->submissions->whereBetween('marks', [$maxMarks * 0.7, $maxMarks * 0.8])->count(),
            'C' => $assignment->submissions->whereBetween('marks', [$maxMarks * 0.6, $maxMarks * 0.7])->count(),
            'D' => $assignment->submissions->whereBetween('marks', [$maxMarks * 0.5, $maxMarks * 0.6])->count(),
            'F' => $assignment->submissions->where('marks', '<', $maxMarks * 0.5)->count(),
        ];

        return view('grading.dashboard', compact(
            'assignment', 
            'totalSubmissions',
            'gradedSubmissions',
            'pendingSubmissions',
            'averageMarks',
            'maxMarks',
            'gradeDistribution'
        ));
    }

    /**
     * Bulk grade submissions
     */
    public function bulkGrade(Request $request, $assignmentId)
    {
        $assignment = Assignment::findOrFail($assignmentId);
        
        $request->validate([
            'submissions' => 'required|array',
            'submissions.*.id' => 'required|exists:assignment_submissions,id',
            'submissions.*.marks' => 'required|numeric|min:0|max:' . $assignment->max_marks,
            'submissions.*.feedback' => 'nullable|string|max:500'
        ]);

        foreach ($request->submissions as $submissionData) {
            $submission = AssignmentSubmission::find($submissionData['id']);
            if ($submission) {
                $submission->update([
                    'marks' => $submissionData['marks'],
                    'feedback' => $submissionData['feedback'],
                    'graded_at' => now()
                ]);
            }
        }

        return response()->json(['success' => true, 'message' => 'Submissions graded successfully!']);
    }

    /**
     * Export grades to CSV
     */
    public function exportGrades($assignmentId)
    {
        $assignment = Assignment::with(['submissions.student'])->findOrFail($assignmentId);
        
        $fileName = 'grades_' . str_replace(' ', '_', $assignment->title) . '_' . now()->format('Y_m_d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $handle = fopen('php://output', 'w');
        fputcsv($handle, ['Student Name', 'Student Email', 'Marks', 'Max Marks', 'Percentage', 'Status', 'Feedback']);

        foreach ($assignment->submissions as $submission) {
            $percentage = $submission->marks ? round(($submission->marks / $assignment->max_marks) * 100, 2) : 0;
            $status = $submission->isGraded() ? 'Graded' : 'Pending';
            
            fputcsv($handle, [
                $submission->student->name,
                $submission->student->email,
                $submission->marks ?? 'N/A',
                $assignment->max_marks,
                $percentage . '%',
                $status,
                $submission->feedback ?? 'No feedback'
            ]);
        }

        fclose($handle);
        
        return response()->streamDownload(function() use ($handle) {
            //
        }, $fileName, $headers);
    }
}