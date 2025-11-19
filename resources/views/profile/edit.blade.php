@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="container py-4">
    <h2 class="text-uptm-blue"><i class="fas fa-user-edit me-2"></i>Edit Profile</h2>
    <hr>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
        </div>

        @if($user->role === 'student')
        <div class="mb-3">
            <label class="form-label">Student ID</label>
            <input type="text" name="student_id" value="{{ old('student_id', $user->student_id) }}" class="form-control">
        </div>
        @endif

        <button type="submit" class="btn btn-uptm-blue">
            <i class="fas fa-save me-1"></i>Save Changes
        </button>
    </form>
</div>
@endsection
