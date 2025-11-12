<!DOCTYPE html>
<html>
<head>
    <title>Submit Assignment - {{ $assignment->title }} - UPTM eCampus</title>
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
        .assignment-card { border-left: 4px solid #1e3a8a; }
        .submission-card { border-left: 4px solid #10b981; }
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
                            <a href="{{ url('/student') }}" class="nav-link">
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
                            <a href="{{ url('/student') }}#grades-section" class="nav-link">
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

                <div class="row">
                    <!-- Assignment Details -->
                    <div class="col-lg-6">
                        <div class="card assignment-card shadow-sm mb-4">
                            <div class="card-header bg-white">
                                <h5 class="card-title mb-0 text-uptm-blue">
                                    <i class="fas fa-tasks me-2"></i>Assignment Details
                                </h5>
                            </div>
                            <div class="card-body">
                                <h4 class="text-uptm-blue">{{ $assignment->title }}</h4>
                                <p class="text-muted">{{ $assignment->description }}</p>
                                
                                <div class="row mt-4">
                                    <div class="col-6">
                                        <small class="text-muted">Subject</small>
                                        <p class="mb-2"><strong>{{ $assignment->subject->name ?? 'General' }}</strong></p>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Due Date</small>
                                        <p class="mb-2">
                                            <strong>{{ \Carbon\Carbon::parse($assignment->due_date)->format('M j, Y g:i A') }}</strong>
                                            @if($assignment->isOverdue())
                                                <span class="badge bg-danger ms-1">Overdue</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-6">
                                        <small class="text-muted">Maximum Marks</small>
                                        <p class="mb-2"><strong>{{ $assignment->max_marks }}</strong></p>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Lecturer</small>
                                        <p class="mb-2"><strong>{{ $assignment->lecturer->name ?? 'N/A' }}</strong></p>
                                    </div>
                                </div>

                                @if($assignment->file_path)
                                    <div class="mt-3">
                                        <a href="{{ Storage::url($assignment->file_path) }}" 
                                           class="btn btn-outline-primary btn-sm" target="_blank">
                                            <i class="fas fa-download me-1"></i>Download Assignment File
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Submission Section -->
                    <div class="col-lg-6">
                        <div class="card submission-card shadow-sm">
                            <div class="card-header bg-white">
                                <h5 class="card-title mb-0 text-success">
                                    <i class="fas fa-paper-plane me-2"></i>Your Submission
                                </h5>
                            </div>
                            <div class="card-body">
                                @if($userSubmission)
                                    <!-- Already Submitted -->
                                    <div class="alert alert-success">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-check-circle fa-2x me-3"></i>
                                            <div>
                                                <h6 class="mb-1">Submitted Successfully!</h6>
                                                <p class="mb-0">Submitted on: {{ $userSubmission->submitted_at->format('M j, Y g:i A') }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"><strong>Your File</strong></label>
                                        <div>
                                            <a href="{{ Storage::url($userSubmission->file_path) }}" 
                                               class="btn btn-outline-primary btn-sm" target="_blank">
                                                <i class="fas fa-download me-1"></i>Download Your Submission
                                            </a>
                                        </div>
                                    </div>

                                    @if($userSubmission->comments)
                                        <div class="mb-3">
                                            <label class="form-label"><strong>Your Comments</strong></label>
                                            <p class="text-muted">{{ $userSubmission->comments }}</p>
                                        </div>
                                    @endif

                                    <!-- Grading Information -->
                                    @if($userSubmission->isGraded())
                                        <div class="alert alert-info mt-3">
                                            <h6><i class="fas fa-star me-2"></i>Graded</h6>
                                            <p class="mb-1"><strong>Marks: {{ $userSubmission->marks }}/{{ $assignment->max_marks }}</strong></p>
                                            @if($userSubmission->feedback)
                                                <p class="mb-0"><strong>Feedback:</strong> {{ $userSubmission->feedback }}</p>
                                            @endif
                                        </div>
                                    @else
                                        <div class="alert alert-warning mt-3">
                                            <i class="fas fa-clock me-2"></i>Your submission is pending review
                                        </div>
                                    @endif

                                @else
                                    <!-- Not Submitted Yet -->
                                    @if($assignment->isOverdue())
                                        <div class="alert alert-danger">
                                            <i class="fas fa-exclamation-triangle me-2"></i>This assignment is overdue!
                                        </div>
                                    @endif

                                    <form action="{{ route('assignments.submit', $assignment->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="file" class="form-label"><strong>Upload Your Work</strong></label>
                                            <input type="file" class="form-control" id="file" name="file" required accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                            <div class="form-text">Supported formats: PDF, Word, JPEG, PNG (Max: 10MB)</div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="comments" class="form-label"><strong>Comments (Optional)</strong></label>
                                            <textarea class="form-control" id="comments" name="comments" rows="3" placeholder="Add any comments about your submission..."></textarea>
                                        </div>

                                        <button type="submit" class="btn btn-uptm-blue w-100">
                                            <i class="fas fa-paper-plane me-2"></i>Submit Assignment
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>

                        <!-- Back Button -->
                        <div class="mt-3">
                            <a href="{{ route('assignments.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Back to Assignments
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>