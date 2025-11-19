@extends('layouts.app')

@section('title', 'Subject Details')

@section('content')
<div class="container py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-uptm-blue mb-0">
            <i class="fas fa-book me-2"></i>{{ $subject->name }}
        </h2>
        <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-uptm-blue">
            <i class="fas fa-arrow-left me-1"></i>Back
        </a>
    </div>

    <!-- Subject Info Card -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <h5 class="text-uptm-blue"><i class="fas fa-code me-2"></i>Code</h5>
                    <p class="text-muted">{{ $subject->code }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <h5 class="text-uptm-blue"><i class="fas fa-star me-2"></i>Credits</h5>
                    <p class="text-muted">{{ $subject->credits }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <h5 class="text-uptm-blue"><i class="fas fa-users me-2"></i>Enrolled Students</h5>
                    <p class="text-muted">{{ $subject->students_count ?? 0 }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <h5 class="text-uptm-blue"><i class="fas fa-chalkboard-teacher me-2"></i>Lecturer</h5>
                    <p class="text-muted">{{ Auth::user()->name }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="d-flex gap-2">
        <a href="{{ route('assignments.indexlect') }}" class="btn btn-uptm-blue">
            <i class="fas fa-tasks me-1"></i>Assignments
        </a>
        <a href="{{ route('subjects.show', $subject->id) }}#students" class="btn btn-outline-uptm-blue">
            <i class="fas fa-list me-1"></i>View Students
        </a>
        <a href="{{ route('assignments.create') }}" class="btn btn-uptm-red">
            <i class="fas fa-plus me-1"></i>Create Assignment
        </a>
    </div>
</div>
@endsection
