<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - UPTM eCampus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .bg-uptm-blue {
            background-color: #1e3a8a !important;
        }
        .bg-uptm-red {
            background-color: #dc2626 !important;
        }
        .bg-uptm-light {
            background-color: #f8fafc !important;
        }
        .text-uptm-blue {
            color: #1e3a8a !important;
        }
        .text-uptm-red {
            color: #dc2626 !important;
        }
        .btn-uptm-blue {
            background-color: #1e3a8a;
            border-color: #1e3a8a;
            color: white;
        }
        .btn-uptm-blue:hover {
            background-color: #1e40af;
            border-color: #1e40af;
            color: white;
        }
        .btn-uptm-red {
            background-color: #dc2626;
            border-color: #dc2626;
            color: white;
        }
        .btn-uptm-red:hover {
            background-color: #ef4444;
            border-color: #ef4444;
            color: white;
        }
        .card-header-blue {
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
            color: white;
        }
        .stat-card {
            border-left: 4px solid #1e3a8a;
            transition: transform 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-2px);
        }
        .sidebar {
            background: linear-gradient(180deg, #1e3a8a, #3b82f6);
            min-height: 100vh;
        }
        .sidebar .nav-link {
            color: white;
            padding: 12px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: rgba(255,255,255,0.1);
            color: white;
        }
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
                    <i class="fas fa-user-cog me-1"></i> {{ $user->name }} (Administrator)
                </span>
                <!-- LOGOUT BUTTON -->
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
                            <a href="#" class="nav-link active">
                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-users me-2"></i>User Management
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-book me-2"></i>Subject Management
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-cog me-2"></i>System Settings
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-chart-bar me-2"></i>Analytics
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-database me-2"></i>Backup
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-clipboard-list me-2"></i>Activity Logs
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-bullhorn me-2"></i>System Announcements
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
                        <h4 class="mb-0"><i class="fas fa-cogs me-2"></i>Admin Dashboard</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <h5 class="text-uptm-blue">Welcome, {{ $user->name }}!</h5>
                                <p class="text-muted mb-0">System Administrator</p>
                                <p class="text-muted">UPTM eCampus Hub Management</p>
                            </div>
                            <div class="col-md-4 text-end">
                                <div class="badge bg-uptm-red fs-6 p-2">Administrator</div>
                            </div>
                        </div>

                        <!-- Statistics Cards -->
                        <div class="row">
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card stat-card border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-uptm-blue text-uppercase mb-1">
                                                    Total Students
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">1</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-user-graduate fa-2x text-uptm-blue"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card stat-card border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-uptm-blue text-uppercase mb-1">
                                                    Total Lecturers
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">1</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-chalkboard-teacher fa-2x text-uptm-red"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card stat-card border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-uptm-blue text-uppercase mb-1">
                                                    Active Subjects
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-book fa-2x text-uptm-blue"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card stat-card border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-uptm-blue text-uppercase mb-1">
                                                    System Status
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-success">Online</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-server fa-2x text-uptm-red"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-header bg-white">
                                        <h6 class="mb-0 text-uptm-blue">System Management</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex gap-2 flex-wrap">
                                            <a href="/student" class="btn btn-uptm-blue">
                                                <i class="fas fa-user-graduate me-1"></i>Student View
                                            </a>
                                            <a href="/lecturer" class="btn btn-uptm-red">
                                                <i class="fas fa-chalkboard-teacher me-1"></i>Lecturer View
                                            </a>
                                            <button class="btn btn-outline-uptm-blue">
                                                <i class="fas fa-user-plus me-1"></i>Add User
                                            </button>
                                            <button class="btn btn-outline-uptm-red">
                                                <i class="fas fa-book-medical me-1"></i>Add Subject
                                            </button>
                                            <button class="btn btn-outline-uptm-blue">
                                                <i class="fas fa-database me-1"></i>System Backup
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- System Overview -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <h6 class="mb-0 text-uptm-blue">System Overview</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-uptm-blue">Platform Information</h6>
                                <ul class="list-unstyled">
                                    <li><strong>Platform:</strong> UPTM eCampus Hub</li>
                                    <li><strong>Version:</strong> 1.0.0</li>
                                    <li><strong>Framework:</strong> Laravel</li>
                                    <li><strong>Database:</strong> MySQL</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-uptm-blue">Quick Stats</h6>
                                <ul class="list-unstyled">
                                    <li><strong>Total Users:</strong> 3</li>
                                    <li><strong>Active Sessions:</strong> 1</li>
                                    <li><strong>Last Backup:</strong> Never</li>
                                    <li><strong>System Uptime:</strong> 100%</li>
                                </ul>
                            </div>
                        </div>
                        <div class="alert alert-success border-0 mt-3">
                            <i class="fas fa-check-circle me-2"></i>
                            <strong>System Running Smoothly!</strong> All services are operational and running at optimal performance.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>