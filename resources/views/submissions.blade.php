<!DOCTYPE html>
<html>
<head>
    <title>Submissions - {{ $assignment->title }} - UPTM eCampus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .bg-uptm-blue { background-color: #1e3a8a !important; }
        .bg-uptm-red { background-color: #dc2626 !important; }
        .bg-uptm-light { background-color: #f8fafc !important; }
        .text-uptm-blue { color: #1e3a8a !important; }
        .text-uptm-red { color: #dc2626 !important; }
        .btn-uptm-blue { background-color: #1e3a8a; border-color: #1e3a8a; color: white; }
        .btn-uptm-blue:hover { background-color: #1e40af; border-color: #1e40af; color: white; }
        .btn-uptm-red { background-color: #dc2626; border-color: #dc2626; color: white; }
        .btn-uptm-red:hover { background-color: #ef4444; border-color: #ef4444; color: white; }
        .sidebar { background: linear-gradient(180deg, #1e3a8a, #3b82f6); min-height: 100vh; }
        .sidebar .nav-link { color: white; padding: 12px 20px; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background-color: rgba(255,255,255,0.1); color: white; }
    </style>
</head>
<body class="bg-uptm-light">
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-uptm-blue">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-graduation-cap me-2"></i>UPTM eCampus Hub
            </a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text text-white me-3">
                    <i class="fas fa-user me-1"></i> {{ Auth::user()->name }} ({{ ucfirst(Auth::user()->role) }})
                </span>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-sign-out-alt me-1"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar p-0">
                <div class="d-flex flex-column flex-shrink-0 p-3 text-white">
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <a href="{{ url('/lecturer') }}" class="nav-link">
                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('announcements.index') }}" class="nav-link">
                                <i class="fas fa-bullhorn me-2"></i>Announcements
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('assignments.index') }}" class="nav-link active">
                                <i class="fas fa-tasks me-2"></i>Assignments
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/lecturer') }}#grades-section" class="nav-link">
                                <i class="fas fa-chart-bar me-2"></i>Grades
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 ml-sm-auto px-4 py-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="card shadow-sm">
                    <div class="card-header bg-uptm-blue text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0">Submissions for: {{ $assignment->title }}</h4>
                                <small class="text-light">
                                    {{ $assignment->subject->name ?? 'General' }} • 
                                    {{ $assignment->submissions->count() }} Submissions •
                                    Due: {{ \Carbon\Carbon::parse($assignment->due_date)->format('M j, Y g:i A') }}
                                </small>
                            </div>
                            <a href="{{ route('assignments.index') }}" class="btn btn-outline-light btn-sm">
                                <i class="fas fa-arrow-left me-1"></i>Back to Assignments
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($assignment->submissions->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Student</th>
                                            <th>Submitted On</th>
                                            <th>File</th>
                                            <th>Comments</th>
                                            <th>Status</th>
                                            <th>Marks</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($assignment->submissions as $submission)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-user-circle me-2 text-uptm-blue"></i>
                                                    {{ $submission->student->name }}
                                                </div>
                                            </td>
                                            <td>{{ $submission->submitted_at->format('M j, Y g:i A') }}</td>
                                            <td>
                                                <a href="{{ route('submissions.download', $submission->id) }}" 
                                                   class="btn btn-sm btn-outline-primary" target="_blank">
                                                    <i class="fas fa-download me-1"></i>Download
                                                </a>
                                            </td>
                                            <td>
                                                <span class="text-muted">{{ $submission->comments ?? 'No comments' }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $submission->isGraded() ? 'success' : 'warning' }}">
                                                    {{ $submission->getGradeStatus() }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($submission->isGraded())
                                                    <strong class="text-uptm-blue">{{ $submission->marks }}/{{ $assignment->max_marks }}</strong>
                                                    @if($submission->feedback)
                                                        <br><small class="text-muted" title="{{ $submission->feedback }}">
                                                            <i class="fas fa-comment me-1"></i>Has feedback
                                                        </small>
                                                    @endif
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-uptm-blue grade-btn" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#gradingModal"
                                                        data-submission-id="{{ $submission->id }}"
                                                        data-student-name="{{ $submission->student->name }}"
                                                        data-current-marks="{{ $submission->marks }}"
                                                        data-max-marks="{{ $assignment->max_marks }}"
                                                        data-feedback="{{ $submission->feedback }}">
                                                    <i class="fas fa-edit me-1"></i>Grade
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No Submissions Yet</h5>
                                <p class="text-muted">Students haven't submitted any work for this assignment yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grading Modal -->
    <div class="modal fade" id="gradingModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-uptm-blue text-white">
                    <h5 class="modal-title">Grade Submission</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="gradingForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Student</label>
                            <input type="text" class="form-control" id="studentName" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Marks</label>
                            <input type="number" name="marks" class="form-control" id="marksInput" 
                                   min="0" max="100" required>
                            <div class="form-text">Maximum marks: <span id="maxMarks">100</span></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Feedback</label>
                            <textarea name="feedback" class="form-control" rows="4" 
                                      placeholder="Provide feedback to the student..." id="feedbackInput"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-uptm-blue">Save Grade</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const gradingModal = document.getElementById('gradingModal');
            const gradingForm = document.getElementById('gradingForm');
            
            if (gradingModal) {
                gradingModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    const submissionId = button.getAttribute('data-submission-id');
                    const studentName = button.getAttribute('data-student-name');
                    const currentMarks = button.getAttribute('data-current-marks');
                    const maxMarks = button.getAttribute('data-max-marks');
                    const feedback = button.getAttribute('data-feedback');

                    document.getElementById('studentName').value = studentName;
                    document.getElementById('marksInput').value = currentMarks || '';
                    document.getElementById('marksInput').max = maxMarks;
                    document.getElementById('maxMarks').textContent = maxMarks;
                    document.getElementById('feedbackInput').value = feedback || '';

                    gradingForm.action = `/submissions/${submissionId}/grade`;
                });
            }
        });
    </script>
</body>
</html>