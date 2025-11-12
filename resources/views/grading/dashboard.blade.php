<!DOCTYPE html>
<html>
<head>
    <title>Grading Dashboard - {{ $assignment->title }} - UPTM eCampus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .bg-uptm-blue { background-color: #1e3a8a !important; }
        .bg-uptm-red { background-color: #dc2626 !important; }
        .bg-uptm-light { background-color: #f8fafc !important; }
        .text-uptm-blue { color: #1e3a8a !important; }
        .text-uptm-red { color: #dc2626 !important; }
        .btn-uptm-blue { background-color: #1e3a8a; border-color: #1e3a8a; color: white; }
        .btn-uptm-blue:hover { background-color: #1e40af; border-color: #1e40af; color: white; }
        .sidebar { background: linear-gradient(180deg, #1e3a8a, #3b82f6); min-height: 100vh; }
        .sidebar .nav-link { color: white; padding: 12px 20px; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background-color: rgba(255,255,255,0.1); color: white; }
        .stat-card { border-left: 4px solid #1e3a8a; transition: transform 0.2s; }
        .stat-card:hover { transform: translateY(-2px); }
        .grade-A { background-color: #10b981; }
        .grade-B { background-color: #3b82f6; }
        .grade-C { background-color: #f59e0b; }
        .grade-D { background-color: #ef4444; }
        .grade-F { background-color: #dc2626; }
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
                            <a href="{{ route('grading.dashboard', $assignment->id) }}" class="nav-link">
                                <i class="fas fa-chart-bar me-2"></i>Grading Analytics
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 ml-sm-auto px-4 py-4">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="text-uptm-blue mb-1">Grading Dashboard</h2>
                        <p class="text-muted mb-0">{{ $assignment->title }} • {{ $assignment->subject->name ?? 'General' }}</p>
                    </div>
                    <div>
                        <a href="{{ route('assignments.submissions', $assignment->id) }}" class="btn btn-uptm-blue">
                            <i class="fas fa-list me-1"></i>View Submissions
                        </a>
                        <a href="{{ route('grading.export', $assignment->id) }}" class="btn btn-success">
                            <i class="fas fa-download me-1"></i>Export Grades
                        </a>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card stat-card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="card-title text-muted">Total Submissions</h6>
                                        <h3 class="text-uptm-blue">{{ $totalSubmissions }}</h3>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-inbox fa-2x text-uptm-blue"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card stat-card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="card-title text-muted">Graded</h6>
                                        <h3 class="text-success">{{ $gradedSubmissions }}</h3>
                                        <small class="text-muted">{{ $totalSubmissions > 0 ? round(($gradedSubmissions/$totalSubmissions)*100, 1) : 0 }}% complete</small>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-check-circle fa-2x text-success"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card stat-card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="card-title text-muted">Pending</h6>
                                        <h3 class="text-warning">{{ $pendingSubmissions }}</h3>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-clock fa-2x text-warning"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card stat-card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="card-title text-muted">Average Marks</h6>
                                        <h3 class="text-info">{{ $averageMarks ? round($averageMarks, 1) : '0' }}/{{ $maxMarks }}</h3>
                                        <small class="text-muted">{{ $averageMarks ? round(($averageMarks/$maxMarks)*100, 1) : 0 }}% average</small>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-chart-line fa-2x text-info"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Row -->
                <div class="row mb-4">
                    <!-- Grade Distribution Chart -->
                    <div class="col-lg-8 mb-4">
                        <div class="card h-100">
                            <div class="card-header bg-white">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-chart-pie me-2"></i>Grade Distribution
                                </h5>
                            </div>
                            <div class="card-body">
                                <canvas id="gradeDistributionChart" height="250"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="col-lg-4 mb-4">
                        <div class="card h-100">
                            <div class="card-header bg-white">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-bolt me-2"></i>Quick Actions
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <a href="{{ route('assignments.submissions', $assignment->id) }}" class="btn btn-uptm-blue">
                                        <i class="fas fa-edit me-2"></i>Grade Submissions
                                    </a>
                                    <a href="{{ route('grading.export', $assignment->id) }}" class="btn btn-success">
                                        <i class="fas fa-file-export me-2"></i>Export to CSV
                                    </a>
                                    <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#bulkGradeModal">
                                        <i class="fas fa-layer-group me-2"></i>Bulk Grade
                                    </button>
                                </div>
                                
                                <!-- Progress Summary -->
                                <div class="mt-4">
                                    <h6>Grading Progress</h6>
                                    <div class="progress mb-2" style="height: 10px;">
                                        <div class="progress-bar bg-success" role="progressbar" 
                                             style="width: {{ $totalSubmissions > 0 ? ($gradedSubmissions/$totalSubmissions)*100 : 0 }}%">
                                        </div>
                                    </div>
                                    <small class="text-muted">
                                        {{ $gradedSubmissions }} of {{ $totalSubmissions }} submissions graded
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Grade Breakdown -->
                <div class="row">
                    @foreach($gradeDistribution as $grade => $count)
                    <div class="col-md-2 col-4 mb-3">
                        <div class="card text-center grade-{{ $grade }} text-white">
                            <div class="card-body py-3">
                                <h4 class="mb-1">{{ $grade }}</h4>
                                <h2 class="mb-0">{{ $count }}</h2>
                                <small>Students</small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Bulk Grade Modal -->
    <div class="modal fade" id="bulkGradeModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-uptm-blue text-white">
                    <h5 class="modal-title">Bulk Grade Submissions</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted">Assign marks to multiple submissions at once.</p>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Current Marks</th>
                                    <th>New Marks</th>
                                    <th>Feedback</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($assignment->submissions->whereNull('marks') as $submission)
                                <tr>
                                    <td>{{ $submission->student->name }}</td>
                                    <td>
                                        <span class="badge bg-warning">Pending</span>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm bulk-marks" 
                                               data-submission-id="{{ $submission->id }}"
                                               min="0" max="{{ $maxMarks }}" placeholder="0-{{ $maxMarks }}">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm bulk-feedback"
                                               data-submission-id="{{ $submission->id }}"
                                               placeholder="Quick feedback">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-uptm-blue" id="saveBulkGrades">
                        <i class="fas fa-save me-1"></i>Save All Grades
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Grade Distribution Chart
        const gradeCtx = document.getElementById('gradeDistributionChart').getContext('2d');
        const gradeChart = new Chart(gradeCtx, {
            type: 'doughnut',
            data: {
                labels: ['A (80-100%)', 'B (70-79%)', 'C (60-69%)', 'D (50-59%)', 'F (<50%)'],
                datasets: [{
                    data: [
                        {{ $gradeDistribution['A'] }},
                        {{ $gradeDistribution['B'] }},
                        {{ $gradeDistribution['C'] }},
                        {{ $gradeDistribution['D'] }},
                        {{ $gradeDistribution['F'] }}
                    ],
                    backgroundColor: [
                        '#10b981',
                        '#3b82f6',
                        '#f59e0b',
                        '#ef4444',
                        '#dc2626'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Bulk Grading
        document.getElementById('saveBulkGrades').addEventListener('click', function() {
            const submissions = [];
            let hasErrors = false;

            document.querySelectorAll('.bulk-marks').forEach(input => {
                const submissionId = input.dataset.submissionId;
                const marks = input.value;
                const feedback = document.querySelector(`.bulk-feedback[data-submission-id="${submissionId}"]`).value;

                if (marks) {
                    submissions.push({
                        id: submissionId,
                        marks: parseFloat(marks),
                        feedback: feedback
                    });
                }
            });

            if (submissions.length === 0) {
                alert('Please enter marks for at least one submission.');
                return;
            }

            // Validate marks
            for (let sub of submissions) {
                if (sub.marks < 0 || sub.marks > {{ $maxMarks }}) {
                    alert(`Marks must be between 0 and {{ $maxMarks }} for all submissions.`);
                    hasErrors = true;
                    break;
                }
            }

            if (!hasErrors) {
                fetch('{{ route("grading.bulk", $assignment->id) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ submissions: submissions })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Grades saved successfully!');
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error saving grades. Please try again.');
                });
            }
        });
    </script>
</body>
</html>