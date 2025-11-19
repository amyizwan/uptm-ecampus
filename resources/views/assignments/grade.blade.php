@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 ml-sm-auto px-4 py-4">
            <div class="card shadow-sm">
                <div class="card-header bg-uptm-blue text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-clipboard-check me-2"></i> Grade Submission
                    </h4>
                    <a href="{{ route('assignments.submissions', $assignment->id) }}" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Back to Submissions
                    </a>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5 class="text-uptm-blue">{{ $submission->student->name }}</h5>
                        <p class="mb-1"><strong>Assignment:</strong> {{ $assignment->title }}</p>
                        <p class="mb-1"><strong>Submitted On:</strong> {{ $submission->submitted_at->format('M j, Y g:i A') }}</p>
                        <p class="mb-1"><strong>File:</strong> 
    <a href="{{ route('submissions.download', $submission->id) }}" 
       class="btn btn-sm btn-outline-primary">
        <i class="fas fa-download me-1"></i> Download
    </a>
</p>

                    </div>

                    <form method="POST" action="{{ route('assignments.grade.store', [$assignment->id, $submission->id]) }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="marks" class="form-label"><i class="fas fa-star me-1"></i> Marks</label>
                                    <input type="number" class="form-control" id="marks" name="marks" 
                                           min="0" max="{{ $assignment->max_marks }}" required>
                                    <small class="form-text text-muted">Max: {{ $assignment->max_marks }}</small>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="feedback" class="form-label"><i class="fas fa-comment-dots me-1"></i> Feedback</label>
                                    <textarea class="form-control" id="feedback" name="feedback" rows="4" 
                                              placeholder="Write constructive feedback..."></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2 mt-3">
                            <button type="submit" class="btn btn-uptm-blue">
                                <i class="fas fa-save me-1"></i> Save Grade
                            </button>
                            <a href="{{ route('assignments.submissions', $assignment->id) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
