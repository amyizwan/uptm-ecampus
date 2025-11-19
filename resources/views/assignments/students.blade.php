@extends('layouts.app')

@section('title', 'Enrolled Students')

@section('content')
<div class="container py-4">
    <h2 class="text-uptm-blue">
        <i class="fas fa-users me-2"></i> Students in {{ $subject->name }}
    </h2>
    <hr>

    @if($subject->students->count() > 0)
        <table class="table table-striped table-hover shadow-sm">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Student ID</th>
                </tr>
            </thead>
            <tbody>
                @foreach($subject->students as $index => $student)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->student_id }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-muted">No students enrolled in this subject yet.</p>
    @endif
</div>
@endsection
