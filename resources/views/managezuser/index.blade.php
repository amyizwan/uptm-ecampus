@extends('layouts.admin')

@section('title', 'User Management')

@section('content')
<div class="container py-4">
    <h2 class="text-uptm-blue"><i class="fas fa-users me-2"></i>User Management</h2>
    <hr>

    <!-- Filter by Role -->
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

    <form method="GET" action="{{ route('admin.users') }}" class="mb-3">
        <div class="row">
            <div class="col-md-4">
                <select name="role" class="form-select" onchange="this.form.submit()">
                    <option value="">All Roles</option>
                    <option value="student" {{ $role === 'student' ? 'selected' : '' }}>Student</option>
                    <option value="lecturer" {{ $role === 'lecturer' ? 'selected' : '' }}>Lecturer</option>
                    <option value="admin" {{ $role === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
        </div>
    </form>

    <!-- Add User Form -->
    <form method="POST" action="{{ route('admin.users.store') }}" class="mb-4">
        @csrf
        <div class="row g-2">
            <div class="col-md-3">
                <input type="text" name="name" class="form-control" placeholder="Name" required>
            </div>
            <div class="col-md-3">
                <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="col-md-2">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <div class="col-md-2">
                <select name="role" class="form-select" required>
                    <option value="student">Student</option>
                    <option value="lecturer">Lecturer</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-uptm-blue w-100">Add User</button>
            </div>
        </div>
    </form>

    <!-- User Table -->
    @if($users->count() > 0)
        <table class="table table-striped table-hover shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ ucfirst($user->role) }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.users.delete', $user->id) }}" onsubmit="return confirm('Delete this user?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-muted">No users found.</p>
    @endif
</div>
@endsection
