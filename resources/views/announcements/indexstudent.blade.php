@extends('layouts.student')

@section('title', 'Announcements')

@section('content')
    <h2 class="text-uptm-blue"><i class="fas fa-bullhorn me-2"></i>Announcements</h2>
    <hr>

    @if($announcements->count() > 0)
        <div class="list-group">
            @foreach($announcements as $announcement)
                <div class="list-group-item list-group-item-action mb-3 shadow-sm">
                    <h5 class="mb-1 text-uptm-blue">{{ $announcement->title }}</h5>
                    <p class="mb-1 text-muted small">
                        <i class="fas fa-book me-1"></i>{{ $announcement->subject->name ?? 'General' }}
                        <br>
                        <i class="fas fa-calendar-alt me-1"></i>{{ $announcement->created_at->format('M d, Y') }}
                    </p>
                    <p>{{ $announcement->content }}</p>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-muted text-center">No announcements available.</p>
    @endif
@endsection
