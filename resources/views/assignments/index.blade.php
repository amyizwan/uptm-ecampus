<!DOCTYPE html>
<html>
<head>
    <title>Assignments - UPTM eCampus</title>
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
        .assignment-card { transition: transform 0.2s; }
        .assignment-card:hover { transform: translateY(-2px); }
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
            <!-- lecturer Sidebar -->
<div class="col-md-3 col-lg-2 sidebar p-0">
    <div class="d-flex flex-column flex-shrink-0 p-3 text-white">
        <ul class="nav nav-pills flex-column mb-auto">

            @if(Auth::user()->role === 'lecturer')
                <li class="nav-item">
                    <a href="{{ route('lecturer.dashboard') }}" class="nav-link">
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
                    <a href="{{ route('lecturer.dashboard') }}#subjects-section" class="nav-link">
                        <i class="fas fa-book me-2"></i>My Subjects
                    </a>
                </li>
                <!-- <li class="nav-item">
                    <a href="{{ route('lecturer.dashboard') }}#grades-section" class="nav-link">
                        <i class="fas fa-chart-bar me-2"></i>Grades
                    </a>
                </li> -->
                <!-- <li class="nav-item">
                    <a href="{{ route('lecturer.dashboard') }}#attendance-section" class="nav-link">
                        <i class="fas fa-calendar-check me-2"></i>Attendance
                    </a>
                </li> -->
                <li class="nav-item">
                    <a href="{{ route('lecturer.dashboard') }}#profile-section" class="nav-link">
                        <i class="fas fa-user me-2"></i>Profile
                    </a>
                </li>
            @endif
            <!-- student sidebar -->
                         @if(Auth::user()->role === 'student')
                <li class="nav-item">
                    <a href="{{ route('student.dashboard') }}" class="nav-link">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('student.announcements.index') }}" class="nav-link">
                        <i class="fas fa-bullhorn me-2"></i>Announcements
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('assignments.index') }}" class="nav-link">
                        <i class="fas fa-tasks me-2"></i>Assignments
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('student.dashboard') }}#grades-section" class="nav-link">
                        <i class="fas fa-chart-bar me-2"></i>Grades
                    </a>
                </li>
                <!-- <li class="nav-item">
                    <a href="{{ route('student.dashboard') }}#attendance-section" class="nav-link">
                        <i class="fas fa-calendar-check me-2"></i>Attendance
                    </a>
                </li> -->
                <!-- <li class="nav-item">
                    <a href="{{ route('student.dashboard') }}#documents-section" class="nav-link">
                        <i class="fas fa-file-alt me-2"></i>Documents
                    </a>
                </li> -->
                <li class="nav-item">
                    <a href="{{ route('student.profile.edit') }}" class="nav-link">
                        <i class="fas fa-user me-2"></i>Profile
                    </a>
                </li>
            @endif
        </ul>
    </div>
</div>

 

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 ml-sm-auto px-4 py-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="text-uptm-blue mb-0">
                        <i class="fas fa-tasks me-2"></i>Assignments
                    </h4>
                    @if(Auth::user()->role === 'lecturer' || Auth::user()->role === 'admin')
                        <a href="{{ route('assignments.create') }}" class="btn btn-uptm-blue">
                            <i class="fas fa-plus me-1"></i>New Assignment
                        </a>
                    @endif
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($assignments->count() > 0)
                    <div class="row">
                        @foreach($assignments as $assignment)
                            <div class="col-md-6 mb-4">
                                <div class="card assignment-card shadow-sm h-100">
                                    <div class="card-header bg-uptm-blue text-white d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">{{ $assignment->title }}</h5>
                                        <!-- LECTURER MANAGEMENT DROPDOWN -->
                                        @if((Auth::user()->role === 'lecturer' && $assignment->lecturer_id == Auth::id()) || Auth::user()->role === 'admin')
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="fas fa-cog"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="{{ route('assignments.edit', $assignment) }}">
                                                        <i class="fas fa-edit me-2"></i>Edit
                                                    </a></li>
                                                    <li><a class="dropdown-item" href="{{ route('assignments.submissions', $assignment) }}">
                                                        <i class="fas fa-list me-2"></i>View Submissions
                                                    </a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <form method="POST" action="{{ route('assignments.destroy', $assignment) }}" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Delete this assignment?')">
                                                                <i class="fas fa-trash me-2"></i>Delete
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text">{{ Str::limit($assignment->description, 150) }}</p>
                                        
                                        <div class="mb-3">
                                            <small class="text-muted">
                                                <i class="fas fa-book me-1"></i>
                                                {{ $assignment->subject->name ?? 'General' }}
                                            </small>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <small class="text-muted">
                                                <i class="fas fa-chalkboard-teacher me-1"></i>
                                                {{ $assignment->lecturer->name ?? 'Unknown Lecturer' }}
                                            </small>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <small class="text-muted">
                                                <i class="fas fa-clock me-1"></i>
                                                Due: {{ $assignment->due_date->format('M j, Y g:i A') }}
                                            </small>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <small class="text-muted">
                                                <i class="fas fa-star me-1"></i>
                                                Max Marks: {{ $assignment->max_marks }}
                                            </small>
                                        </div>

                                        <!-- LECTURER SPECIFIC: Submission Count -->
                                        @if(Auth::user()->role === 'lecturer' && $assignment->lecturer_id == Auth::id())
                                        <div class="mb-3">
                                            <small class="text-muted">
                                                <i class="fas fa-paper-plane me-1"></i>
                                                Submissions: <span class="fw-bold">{{ $assignment->submissions_count ?? 0 }}</span>
                                            </small>
                                        </div>
                                        @endif

                                        <div class="d-flex justify-content-between align-items-center">
                                            
                                            
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('assignments.show', $assignment) }}" class="btn btn-sm btn-uptm-blue">
                                                    <i class="fas fa-eye me-1"></i>View
                                                </a>
                                                @if(Auth::user()->role === 'lecturer' && $assignment->lecturer_id == Auth::id())
                                                    <a href="{{ route('assignments.submissions', $assignment) }}" class="btn btn-sm btn-uptm-red">
                                                        <i class="fas fa-check-circle me-1"></i>Grade
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="card shadow-sm">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-tasks fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No Assignments Yet</h5>
                            <p class="text-muted">There are no assignments to display at the moment.</p>
                            @if(Auth::user()->role === 'lecturer' || Auth::user()->role === 'admin')
                                <a href="{{ route('assignments.create') }}" class="btn btn-uptm-blue">
                                    <i class="fas fa-plus me-1"></i>Create First Assignment
                                </a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>