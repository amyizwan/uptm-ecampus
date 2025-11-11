@extends('layouts.app')

@section('title', 'Create Announcement - UPTM eCampus')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-uptm-blue text-white">
        <h4 class="mb-0"><i class="fas fa-bullhorn me-2"></i>Create New Announcement</h4>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('announcements.store') }}">
            @csrf
            
            <div class="mb-3">
                <label for="title" class="form-label">Announcement Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control" id="content" name="content" rows="6" required></textarea>
            </div>
            
            <div class="mb-3">
                <label for="subject_id" class="form-label">Subject (Optional)</label>
                <select class="form-control" id="subject_id" name="subject_id">
                    <option value="">General Announcement (All Users)</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-uptm-blue">
                    <i class="fas fa-paper-plane me-1"></i>Create Announcement
                </button>
                <a href="{{ route('announcements.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Back to Announcements
                </a>
            </div>
        </form>
    </div>
</div>
@endsection