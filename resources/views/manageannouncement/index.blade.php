@extends('layouts.admin')

@section('title', 'System Announcements')

@section('content')
<div class="container py-4">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-uptm-blue mb-0">
            <i class="fas fa-bullhorn me-2"></i> System Announcements
        </h2>
        <span class="text-muted">Create and manage announcements for your campus system</span>
    </div>

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

    <!-- Add Announcement Form -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-uptm-blue text-white">
            <i class="fas fa-plus-circle me-2"></i> Add New Announcement
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.announcements.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" placeholder="Enter announcement title" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Content</label>
                    <textarea name="content" class="form-control" rows="3" placeholder="Write announcement details..." required></textarea>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Subject</label>
                        <select name="subject_id" class="form-select">
                            <option value="">General (no subject)</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Publish At</label>
                        <input type="datetime-local" name="publish_at" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Expire At</label>
                        <input type="datetime-local" name="expire_at" class="form-control">
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-uptm-blue">
                        <i class="fas fa-save me-1"></i> Save Announcement
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Announcement Table -->
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <i class="fas fa-list me-2"></i> Announcement List
        </div>
        <div class="card-body p-0">
            @if($announcements->count() > 0)
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Title</th>
                            <th>Content</th>
                            <th>Subject</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($announcements as $announcement)
                        <tr>
                            <td>{{ $announcement->title }}</td>
                            <td>{{ Str::limit($announcement->content, 50) }}</td>
                            <td>{{ $announcement->subject ? $announcement->subject->name : 'General' }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.announcements.delete', $announcement->id) }}" onsubmit="return confirm('Delete this announcement?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted p-3">No announcements found.</p>
            @endif
        </div>
    </div>
</div>
@endsection
