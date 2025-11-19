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
                            <a href="{{ route('announcements.index') }}" class="nav-link active">
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
                        <!-- <li class="nav-item">
                            <a href="{{ url('/lecturer') }}#grades-section" class="nav-link">
                                <i class="fas fa-chart-bar me-2"></i>Grades
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/lecturer') }}#attendance-section" class="nav-link">
                                <i class="fas fa-calendar-check me-2"></i>Attendance
                            </a>
                        </li> -->
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
                
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="text-uptm-blue mb-0">
                        <i class="fas fa-tachometer-alt me-2"></i>Announcements
                    </h4>
                    @if(Auth::user()->role === 'lecturer' || Auth::user()->role === 'admin')
                    <a href="{{ route('announcements.create') }}" class="btn btn-uptm-blue">
                        <i class="fas fa-plus me-1"></i>New Announcement
                    </a>
                    @endif
                </div>

                <!-- Example dashboard cards -->
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <i class="fas fa-bullhorn fa-2x text-uptm-blue mb-2"></i>
                                <h5>{{ $myAnnouncementsCount }} Announcements</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Announcements -->
                <h5 class="text-uptm-blue mt-4"><i class="fas fa-bullhorn me-2"></i>Recent Announcements</h5>
                @if($recentAnnouncements->count() > 0)
                    @foreach($recentAnnouncements as $announcement)
                        <div class="card shadow-sm mb-3">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 text-uptm-blue">{{ $announcement->title }}</h6>
                                <span class="badge bg-primary">
                                    {{ $announcement->subject ? $announcement->subject->name : 'General' }}
                                </span>
                            </div>
                            <div class="card-body">
                                <p class="card-text">{{ $announcement->content }}</p>
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>{{ $announcement->created_at->format('M j, Y g:i A') }}
                                </small>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted">No recent announcements.</p>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
