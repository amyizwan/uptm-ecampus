<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function showSubmissions($assignmentId)
    {
        $assignment = Assignment::with(['submissions.student', 'subject'])
            ->findOrFail($assignmentId);
        
        return view('submissions', compact('assignment'));
    }

    public function gradeSubmission(Request $request, $submissionId)
    {
        $submission = Submission::findOrFail($submissionId);
        
        $request->validate([
            'marks' => 'required|numeric|min:0|max:' . $submission->assignment->max_marks,
            'feedback' => 'nullable|string|max:500'
        ]);

        $submission->update([
            'marks' => $request->marks,
            'feedback' => $request->feedback,
            'graded_at' => now(),
            'status' => 'graded'
        ]);

        return redirect()->back()->with('success', 'Submission graded successfully!');
    }

    public function downloadSubmission($submissionId)
    {
        $submission = Submission::findOrFail($submissionId);
        
        if (!Storage::exists($submission->file_path)) {
            return redirect()->back()->with('error', 'File not found.');
        }

        return Storage::download($submission->file_path);
    }
}