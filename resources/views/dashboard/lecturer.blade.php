<!DOCTYPE html>
<html>
<head>
    <title>Lecturer Dashboard - UPTM eCampus</title>
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
                    <i class="fas fa-user me-1"></i> {{ $user->name }} (Lecturer)
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
                            <a href="{{ url('/lecturer') }}" class="nav-link active">
                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('announcements.index') }}" class="nav-link">
                                <i class="fas fa-bullhorn me-2"></i>Announcements
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('assignments.index') }}" class="nav-link">
                                <i class="fas fa-tasks me-2"></i>Assignments
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/lecturer') }}#subjects-section" class="nav-link">
                                <i class="fas fa-book me-2"></i>My Subjects
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/lecturer') }}#grading-section" class="nav-link">
                                <i class="fas fa-chart-bar me-2"></i>Grading
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/lecturer') }}#attendance-section" class="nav-link">
                                <i class="fas fa-calendar-check me-2"></i>Attendance
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/lecturer') }}#profile-section" class="nav-link">
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
                        <h4 class="mb-0"><i class="fas fa-chalkboard-teacher me-2"></i>Lecturer Dashboard</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <h5 class="text-uptm-blue">Welcome, {{ $user->name }}!</h5>
                                <p class="text-muted mb-0">Lecturer Account</p>
                                <p class="text-muted">Faculty of Information Technology</p>
                            </div>
                            <div class="col-md-4 text-end">
                                <div class="badge bg-uptm-red fs-6 p-2">Lecturer</div>
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
                                                        My Announcements
                                                    </div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $myAnnouncementsCount ?? '0' }}</div>
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
                                                        My Assignments
                                                    </div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $myAssignmentsCount ?? '0' }}</div>
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
                                <a href="{{ url('/lecturer') }}#subjects-section" class="text-decoration-none">
                                    <div class="card stat-card border-0 shadow-sm h-100">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-uptm-blue text-uppercase mb-1">
                                                        Teaching Subjects
                                                    </div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $subjectsCount ?? '0' }}</div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-book fa-2x text-uptm-blue"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-xl-3 col-md-6 mb-4">
                                <a href="{{ url('/lecturer') }}#grading-section" class="text-decoration-none">
                                    <div class="card stat-card border-0 shadow-sm h-100">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-uptm-blue text-uppercase mb-1">
                                                        Pending Grading
                                                    </div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingGradingCount ?? '0' }}</div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-check-circle fa-2x text-uptm-red"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white">
                                <h6 class="mb-0 text-uptm-blue">Quick Actions</h6>
                            </div>
                            <div class="card-body">
                                <div class="d-flex gap-2 flex-wrap">
                                    <a href="{{ route('announcements.create') }}" class="btn btn-uptm-blue">
                                        <i class="fas fa-bullhorn me-1"></i>Create Announcement
                                    </a>
                                    <a href="{{ route('assignments.create') }}" class="btn btn-uptm-red">
                                        <i class="fas fa-tasks me-1"></i>Create Assignment
                                    </a>
                                    <a href="{{ url('/lecturer') }}#grading-section" class="btn btn-outline-uptm-blue">
                                        <i class="fas fa-check-circle me-1"></i>Grade Assignments
                                    </a>
                                    <a href="{{ url('/lecturer') }}#attendance-section" class="btn btn-outline-uptm-red">
                                        <i class="fas fa-calendar-check me-1"></i>Take Attendance
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- My Subjects Section -->
                <div class="card border-0 shadow-sm mb-4 mt-4" id="subjects-section">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 text-uptm-blue">
                            <i class="fas fa-book me-2"></i>My Teaching Subjects
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($subjects && $subjects->count() > 0)
                            <div class="row">
                                @foreach($subjects as $subject)
                                <div class="col-md-4 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $subject->name }}</h6>
                                            <p class="card-text text-muted small">
                                                <i class="fas fa-code me-1"></i>{{ $subject->code }}
                                                <br>
                                                <i class="fas fa-users me-1"></i>{{ $subject->students_count ?? '0' }} Students
                                                <br>
                                                <i class="fas fa-star me-1"></i>{{ $subject->credits }} Credits
                                            </p>
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-sm btn-uptm-blue">
                                                    <i class="fas fa-eye me-1"></i>View
                                                </button>
                                                <button class="btn btn-sm btn-outline-uptm-blue">
                                                    <i class="fas fa-list me-1"></i>Students
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted text-center">No subjects assigned to you yet.</p>
                        @endif
                    </div>
                </div>

                <!-- Recent Announcements -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h6 class="mb-0 text-uptm-blue">My Recent Announcements</h6>
                    </div>
                    <div class="card-body">
                        @if($recentAnnouncements && $recentAnnouncements->count() > 0)
                            @foreach($recentAnnouncements as $announcement)
                            <div class="card mb-2">
                                <div class="card-body py-2">
                                    <h6 class="card-title mb-1">{{ $announcement->title }}</h6>
                                    <p class="card-text text-muted small mb-1">{{ Str::limit($announcement->content, 100) }}</p>
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ $announcement->created_at->format('M j, Y') }}
                                        @if($announcement->subject)
                                            • <i class="fas fa-book me-1"></i>{{ $announcement->subject->name }}
                                        @endif
                                    </small>
                                </div>
                            </div>
                            @endforeach
                            <div class="text-center mt-3">
                                <a href="{{ route('announcements.index') }}" class="btn btn-sm btn-uptm-blue">View All Announcements</a>
                            </div>
                        @else
                            <p class="text-muted text-center">No announcements created yet.</p>
                            <div class="text-center">
                                <a href="{{ route('announcements.create') }}" class="btn btn-uptm-blue">
                                    <i class="fas fa-plus me-1"></i>Create First Announcement
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

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
                                        <th>Role:</th>
                                        <td><span class="badge bg-uptm-red">Lecturer</span></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="40%">Faculty:</th>
                                        <td>Faculty of Information Technology</td>
                                    </tr>
                                    <tr>
                                        <th>Department:</th>
                                        <td>Computer Science</td>
                                    </tr>
                                    <tr>
                                        <th>Status:</th>
                                        <td><span class="badge bg-success">Active</span></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button class="btn btn-uptm-blue">
                                <i class="fas fa-edit me-1"></i>Edit Profile
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>