<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard - UPTM eCampus</title>
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
        .card-header-blue { background: linear-gradient(135deg, #1e3a8a, #3b82f6); color: white; }
        .stat-card { border-left: 4px solid #1e3a8a; transition: transform 0.2s; }
        .stat-card:hover { transform: translateY(-2px); }
        .sidebar { background: linear-gradient(180deg, #1e3a8a, #3b82f6); min-height: 100vh; }
        .sidebar .nav-link { color: white; padding: 12px 20px; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background-color: rgba(255,255,255,0.1); color: white; }
        .grade-A { background-color: #d4edda; border-left: 4px solid #28a745; }
        .grade-B { background-color: #fff3cd; border-left: 4px solid #ffc107; }
        .grade-C { background-color: #f8d7da; border-left: 4px solid #dc3545; }
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
                    <i class="fas fa-user me-1"></i> {{ Auth::user()->name }} (Student)
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
                            <a href="{{ url('/student') }}" class="nav-link active">
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
                            <a href="#grades-section" class="nav-link">
                                <i class="fas fa-chart-bar me-2"></i>Grades
                            </a>
                        </li>
                        <!-- <li class="nav-item">
                            <a href="#attendance-section" class="nav-link">
                                <i class="fas fa-calendar-check me-2"></i>Attendance
                            </a>
                        </li> -->
                        <!-- <li class="nav-item">
                            <a href="#documents-section" class="nav-link">
                                <i class="fas fa-file-alt me-2"></i>Documents
                            </a>
                        </li> -->
                        <li class="nav-item">
                            <a href="#profile-section" class="nav-link">
                                <i class="fas fa-user me-2"></i>Profile
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 ml-sm-auto px-4 py-4">
                <!-- Welcome Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header card-header-blue">
                        <h4 class="mb-0"><i class="fas fa-graduation-cap me-2"></i>Student Dashboard</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <h5 class="text-uptm-blue">Welcome, {{ $user->name }}!</h5>
                                <p class="text-muted mb-0">Student ID: {{ $user->student_id ?? 'N/A' }}</p>
                                <p class="text-muted">Program: Bachelor of Information Technology (Cyber Security)</p>
                            </div>
                            <div class="col-md-4 text-end">
                                <div class="badge bg-uptm-red fs-6 p-2">Student</div>
                            </div>
                        </div>

                        <!-- Statistics Cards -->
                        <div class="row">
                            <div class="col-xl-3 col-md-6 mb-4">
                                <a href="{{ route('announcements.index') }}" class="text-decoration-none">
                                    <div class="card stat-card border-0 shadow-sm h-100">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-uptm-blue text-uppercase mb-1">
                                                        Announcements
                                                    </div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $announcementsCount }}</div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-bullhorn fa-2x text-uptm-blue"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-xl-3 col-md-6 mb-4">
                                <a href="{{ route('assignments.index') }}" class="text-decoration-none">
                                    <div class="card stat-card border-0 shadow-sm h-100">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-uptm-blue text-uppercase mb-1">
                                                        Pending Assignments
                                                    </div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingAssignmentsCount }}</div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-tasks fa-2x text-uptm-red"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-xl-3 col-md-6 mb-4">
                                <a href="#grades-section" class="text-decoration-none">
                                    <div class="card stat-card border-0 shadow-sm h-100">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-uptm-blue text-uppercase mb-1">
                                                        Current GPA
                                                    </div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $gpa }}</div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-chart-line fa-2x text-uptm-blue"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- <div class="col-xl-3 col-md-6 mb-4">
                                <a href="#attendance-section" class="text-decoration-none">
                                    <div class="card stat-card border-0 shadow-sm h-100">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-uptm-blue text-uppercase mb-1">
                                                        Attendance
                                                    </div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $attendancePercentage }}%</div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-calendar-check fa-2x text-uptm-red"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div> -->
                        </div>
                    </div>
                </div>

                <!-- Grades Section -->
                <div class="card border-0 shadow-sm mb-4" id="grades-section">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 text-uptm-blue">
                            <i class="fas fa-chart-bar me-2"></i>My Grades
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($grades->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Subject</th>
                                            <th>Assignment</th>
                                            <th>Marks</th>
                                            <th>Grade</th>
                                            <th>Comments</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($grades as $grade)
                                        <tr class="grade-{{ $grade->grade }}">
                                            <td>{{ $grade->subject->name ?? 'N/A' }}</td>
                                            <td>{{ $grade->assignment_name }}</td>
                                            <td>{{ $grade->marks }}/{{ $grade->max_marks }}</td>
                                            <td>
                                                <span class="badge bg-{{ $grade->grade == 'A' ? 'success' : ($grade->grade == 'B' ? 'warning' : 'danger') }}">
                                                    {{ $grade->grade }}
                                                </span>
                                            </td>
                                            <td>{{ $grade->comments ?? '-' }}</td>
                                            <td>{{ $grade->created_at->format('M d, Y') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted text-center">No grades available yet.</p>
                        @endif
                    </div>
                </div>

                <!-- Attendance Section -->
                <!-- <div class="card border-0 shadow-sm mb-4" id="attendance-section">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 text-uptm-blue">
                            <i class="fas fa-calendar-check me-2"></i>Attendance Record
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h3>{{ $attendancePercentage }}%</h3>
                                        <p class="text-muted">Overall Attendance</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h3>{{ $attendance->where('status', 'present')->count() }}</h3>
                                        <p class="text-muted">Classes Attended</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($attendance->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Subject</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($attendance->take(10) as $record)
                                        <tr>
                                            <td>{{ $record->date->format('M d, Y') }}</td>
                                            <td>{{ $record->subject->name ?? 'N/A' }}</td>
                                            <td>
                                                <span class="badge bg-{{ $record->status == 'present' ? 'success' : ($record->status == 'late' ? 'warning' : 'danger') }}">
                                                    {{ ucfirst($record->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted text-center">No attendance records available.</p>
                        @endif
                    </div>
                </div> -->

                <!-- Documents Section
                <div class="card border-0 shadow-sm mb-4" id="documents-section">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 text-uptm-blue">
                            <i class="fas fa-file-alt me-2"></i>Course Documents
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($documents->count() > 0)
                            <div class="row">
                                @foreach($documents as $document)
                                <div class="col-md-6 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $document->title }}</h6>
                                            <p class="card-text text-muted small">
                                                <i class="fas fa-book me-1"></i>{{ $document->subject->name ?? 'General' }}
                                                <br>
                                                <i class="fas fa-tag me-1"></i>{{ ucfirst($document->type) }}
                                            </p>
                                            <a href="#" class="btn btn-sm btn-uptm-blue">
                                                <i class="fas fa-download me-1"></i>Download
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted text-center">No documents available yet.</p>
                        @endif
                    </div>
                </div> -->

                <!-- Profile Section -->
                <div class="card border-0 shadow-sm" id="profile-section">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 text-uptm-blue">
                            <i class="fas fa-user me-2"></i>My Profile
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="40%">Full Name:</th>
                                        <td>{{ $user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email:</th>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Student ID:</th>
                                        <td>{{ $user->student_id ?? 'Not set' }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="40%">Program:</th>
                                        <td>Bachelor of Information Technology (Cyber Security)</td>
                                    </tr>
                                    <tr>
                                        <th>Semester:</th>
                                        <td>Semester 1, 2024</td>
                                    </tr>
                                    <tr>
                                        <th>Status:</th>
                                        <td><span class="badge bg-success">Active</span></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('student.profile.edit') }}" class="btn btn-uptm-blue">
                                <i class="fas fa-edit me-1"></i>Edit Profile
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