<!DOCTYPE html>
<html>
<head>
    <title>Edit Assignment - UPTM eCampus</title>
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

        </ul>
    </div>
</div>


            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 ml-sm-auto px-4 py-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-uptm-blue text-white">
                        <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Assignment</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('assignments.update', $assignment) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Assignment Title</label>
                                        <input type="text" class="form-control" id="title" name="title" value="{{ $assignment->title }}" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="6" required>{{ $assignment->description }}</textarea>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="due_date" class="form-label">Due Date & Time</label>
                                                <input type="datetime-local" class="form-control" id="due_date" name="due_date" value="{{ $assignment->due_date->format('Y-m-d\TH:i') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="max_marks" class="form-label">Maximum Marks</label>
                                                <input type="number" class="form-control" id="max_marks" name="max_marks" min="1" max="100" value="{{ $assignment->max_marks }}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="subject_id" class="form-label">Subject</label>
                                        <select class="form-control" id="subject_id" name="subject_id">
                                            <option value="">General Assignment</option>
                                            @foreach($subjects as $subject)
                                                <option value="{{ $subject->id }}" {{ $assignment->subject_id == $subject->id ? 'selected' : '' }}>
                                                    {{ $subject->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    
                                </div>
                            </div>

                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-uptm-blue">
                                    <i class="fas fa-save me-1"></i>Update Assignment
                                </button>
                                <a href="{{ route('assignments.show', $assignment) }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-1"></i>Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>