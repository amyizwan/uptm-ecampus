<!DOCTYPE html>
<html>
<head>
    <title>Login - UPTM eCampus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center min-vh-100 align-items-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h4><i class="fas fa-graduation-cap"></i> UPTM eCampus Hub</h4>
                        <p class="mb-0">Please login to continue</p>
                    </div>
                    <div class="card-body p-4">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <form method="POST" action="/login">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                            </form>

<!-- Temporary Debug Info -->
<div class="mt-3 p-3 bg-light border rounded">
    <h6>Debug Info:</h6>
    <small class="text-muted">
        @if(Auth::check())
            Logged in as: {{ Auth::user()->name }} ({{ Auth::user()->role }})<br>
            Should redirect to: {{ Auth::user()->getRedirectRoute() }}
        @else
            Not logged in
        @endif
    </small>
</div>

<div class="mb-3 form-check">
    <input type="checkbox" class="form-check-input" id="remember" name="remember">
    <label class="form-check-label" for="remember">Remember Me</label>
</div>

                        <div class="mt-4">
                            <h6>Test Accounts:</h6>
                            <small class="text-muted">
                                <strong>Student:</strong> am2311015254@uptm.edu.my / password123<br>
                                <strong>Lecturer:</strong> lecturer@uptm.edu.my / password123<br>
                                <strong>Admin:</strong> admin@uptm.edu.my / password123
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>