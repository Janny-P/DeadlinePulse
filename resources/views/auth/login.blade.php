@extends('layout')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-sm p-4" style="width: 400px; border-radius:12px;">
        <h4 class="text-center mb-4">Login</h4>
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" placeholder="email@example.com" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="******" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 mb-2">Login</button>
            <p class="text-center">No account? <a href="{{ route('signup.form') }}">Sign up</a></p>
        </form>
    </div>
</div>
@endsection
