@extends('layouts.admin')

@section('title', 'Subject Management')

@section('content')
<div class="container py-4">
    <h2 class="text-uptm-blue"><i class="fas fa-book me-2"></i>Subject Management</h2>
    <hr>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Search Bar -->
    <form method="GET" action="{{ route('admin.subjects') }}" class="mb-3">
        <div class="row">
            <div class="col-md-6">
                <input type="text" name="search" class="form-control" placeholder="Search by name or code"
                       value="{{ $search }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-uptm-blue w-100">Search</button>
            </div>
        </div>
    </form>

    <!-- Add Subject Form -->
    <form method="POST" action="{{ route('admin.subjects.store') }}" class="mb-4">
        @csrf
        <div class="row g-2">
            <div class="col-md-4">
                <input type="text" name="name" class="form-control" placeholder="Subject Name" required>
            </div>
            <div class="col-md-3">
                <input type="text" name="code" class="form-control" placeholder="Subject Code" required>
            </div>
            <div class="col-md-3">
                <select name="lecturer_id" class="form-select" required>
                    <option value="">Select Lecturer</option>
                    @foreach($lecturers as $lecturer)
                        <option value="{{ $lecturer->id }}">{{ $lecturer->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-uptm-blue w-100">Add Subject</button>
            </div>
        </div>
    </form>

    <!-- Subject Table -->
    @if($subjects->count() > 0)
        <table class="table table-striped table-hover shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th>Subject Name</th>
                    <th>Code</th>
                    <th>Lecturer</th>
                    <th>Action</th>
                    <th>Reassign</th>
                </tr>
            </thead>
            <tbody>
                @foreach($subjects as $subject)
                <tr>
                    <td>{{ $subject->name }}</td>
                    <td>{{ $subject->code }}</td>
                    <td>{{ $subject->lecturer ? $subject->lecturer->name : 'N/A' }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.subjects.delete', $subject->id) }}" onsubmit="return confirm('Delete this subject?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                    <td>
    <form method="POST" action="{{ route('admin.subjects.updateLecturer', $subject->id) }}" class="d-flex align-items-center">
        @csrf
        <select name="lecturer_id" class="form-select form-select-sm me-2" required>
            @foreach($lecturers as $lecturer)
                <option value="{{ $lecturer->id }}" 
                    {{ $subject->lecturer_id == $lecturer->id ? 'selected' : '' }}>
                    {{ $lecturer->name }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-sm btn-primary">
            <i class="fas fa-sync-alt"></i> Change
        </button>
    </form>
</td>

                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-muted">No subjects found.</p>
    @endif
</div>
@endsection
