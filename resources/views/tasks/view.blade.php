@extends('layout')

@section('content')
<div class="d-flex justify-content-center mt-5">
    <div class="auth-card shadow-sm p-4 bg-white rounded" style="width: 400px;">
        <h4 class="text-center mb-4">Create Your Account</h4>
        
        <form action="{{ route('signup') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label fw-semibold">Full Name</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Enter your full name" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Email</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-semibold">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Create a password" required>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label fw-semibold">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirm your password" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-2">Sign Up</button>
        </form>

        <p class="text-center mt-3 mb-0">
            Already have an account? 
            <a href="{{ route('login.form') }}" class="text-decoration-none">Log In</a>
        </p>
    </div>
</div>
@endsection
