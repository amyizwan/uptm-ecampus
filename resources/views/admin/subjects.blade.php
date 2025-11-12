<!DOCTYPE html>
<html>
<head>
    <title>Subject Management - UPTM eCampus</title>
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
        .subject-card { border-left: 4px solid #1e3a8a; transition: transform 0.2s; }
        .subject-card:hover { transform: translateY(-2px); }
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
                    <i class="fas fa-user-cog me-1"></i> {{ Auth::user()->name }} (Administrator)
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
                            <a href="{{ route('admin.dashboard') }}" class="nav-link">
                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.users') }}" class="nav-link">
                                <i class="fas fa-users me-2"></i>User Management
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.subjects') }}" class="nav-link active">
                                <i class="fas fa-book me-2"></i>Subject Management
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.settings') }}" class="nav-link">
                                <i class="fas fa-cog me-2"></i>System Settings
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.analytics') }}" class="nav-link">
                                <i class="fas fa-chart-bar me-2"></i>Analytics
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.backup') }}" class="nav-link">
                                <i class="fas fa-database me-2"></i>Backup
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.activity-logs') }}" class="nav-link">
                                <i class="fas fa-clipboard-list me-2"></i>Activity Logs
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

                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-uptm-blue text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0"><i class="fas fa-book me-2"></i>Subject Management</h4>
                                <small class="text-light">Manage courses and subjects in the system</small>
                            </div>
                            <button class="btn btn-outline-light btn-sm" data-bs-toggle="modal" data-bs-target="#addSubjectModal">
                                <i class="fas fa-plus me-1"></i>Add Subject
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($subjects->count() > 0)
                            <div class="row">
                                @foreach($subjects as $subject)
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card subject-card h-100">
                                        <div class="card-header bg-white">
                                            <h6 class="card-title mb-0 text-uptm-blue">{{ $subject->name }}</h6>
                                            <small class="text-muted">{{ $subject->code }}</small>
                                        </div>
                                        <div class="card-body">
                                            <p class="card-text text-muted">
                                                {{ $subject->description ?: 'No description provided.' }}
                                            </p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">
                                                    Created: {{ $subject->created_at->format('M j, Y') }}
                                                </small>
                                                <div class="btn-group">
                                                    <button class="btn btn-sm btn-outline-uptm-blue" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#editSubjectModal"
                                                            data-subject-id="{{ $subject->id }}"
                                                            data-subject-name="{{ $subject->name }}"
                                                            data-subject-code="{{ $subject->code }}"
                                                            data-subject-description="{{ $subject->description }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-danger" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#deleteSubjectModal"
                                                            data-subject-id="{{ $subject->id }}"
                                                            data-subject-name="{{ $subject->name }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-book fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No Subjects Found</h5>
                                <p class="text-muted">Get started by adding your first subject to the system.</p>
                                <button class="btn btn-uptm-blue" data-bs-toggle="modal" data-bs-target="#addSubjectModal">
                                    <i class="fas fa-plus me-1"></i>Add First Subject
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Subject Statistics -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="card text-white bg-primary">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h3>{{ $subjects->count() }}</h3>
                                        <span>Total Subjects</span>
                                    </div>
                                    <i class="fas fa-book fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-success">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h3>{{ $subjects->count() }}</h3>
                                        <span>Active Subjects</span>
                                    </div>
                                    <i class="fas fa-check-circle fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-info">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h3>0</h3>
                                        <span>Assignments</span>
                                    </div>
                                    <i class="fas fa-tasks fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Subject Modal -->
    <div class="modal fade" id="addSubjectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-uptm-blue text-white">
                    <h5 class="modal-title">Add New Subject</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.subjects.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Subject Name</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g., Web Development" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Subject Code</label>
                            <input type="text" name="code" class="form-control" placeholder="e.g., CS101" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Optional subject description..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-uptm-blue">Add Subject</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Subject Modal -->
    <div class="modal fade" id="editSubjectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-uptm-blue text-white">
                    <h5 class="modal-title">Edit Subject</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="editSubjectForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Subject Name</label>
                            <input type="text" name="name" class="form-control" id="editSubjectName" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Subject Code</label>
                            <input type="text" name="code" class="form-control" id="editSubjectCode" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3" id="editSubjectDescription"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-uptm-blue">Update Subject</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Subject Modal -->
    <div class="modal fade" id="deleteSubjectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Delete Subject</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete subject "<strong id="deleteSubjectName"></strong>"?</p>
                    <p class="text-danger"><small>This will also delete all assignments associated with this subject. This action cannot be undone.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteSubjectForm" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Subject</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Edit Subject Modal
        const editSubjectModal = document.getElementById('editSubjectModal');
        if (editSubjectModal) {
            editSubjectModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const subjectId = button.getAttribute('data-subject-id');
                const subjectName = button.getAttribute('data-subject-name');
                const subjectCode = button.getAttribute('data-subject-code');
                const subjectDescription = button.getAttribute('data-subject-description');

                document.getElementById('editSubjectName').value = subjectName;
                document.getElementById('editSubjectCode').value = subjectCode;
                document.getElementById('editSubjectDescription').value = subjectDescription;

                document.getElementById('editSubjectForm').action = `/admin/subjects/${subjectId}`;
            });
        }

        // Delete Subject Modal
        const deleteSubjectModal = document.getElementById('deleteSubjectModal');
        if (deleteSubjectModal) {
            deleteSubjectModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const subjectId = button.getAttribute('data-subject-id');
                const subjectName = button.getAttribute('data-subject-name');

                document.getElementById('deleteSubjectName').textContent = subjectName;
                document.getElementById('deleteSubjectForm').action = `/admin/subjects/${subjectId}`;
            });
        }
    </script>
</body>
</html>