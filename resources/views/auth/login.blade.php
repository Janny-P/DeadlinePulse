@extends('layout')

@section('content')
<div class="container-fluid py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center;">
  <div style="max-width: 450px; width: 100%;">
    <div class="card shadow-lg rounded-5 border-0 overflow-hidden">
      <!-- Header -->
      <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);" class="p-5 text-center text-white">
        <h1 class="fw-bold mb-2" style="font-size: 2.5rem;">
          <i class="bi bi-lock me-2"></i>Welcome Back
        </h1>
        <p class="mb-0 opacity-85">Log in to manage your tasks</p>
      </div>

      <div class="card-body p-5">
        @if (session('error'))
          <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif

        @if ($errors->any())
          <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i><strong>Errors:</strong>
            <ul class="mb-0 mt-2">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif

        <form action="{{ route('task.login') }}" method="POST">
          @csrf

          <div class="mb-4">
            <label class="form-label fw-bold text-dark mb-2">
              <i class="bi bi-envelope me-2 text-primary"></i>Email Address
            </label>
            <input type="email" class="form-control rounded-3 border-2" style="border-color: #e0e0e0; padding: 12px 16px; font-size: 1rem;" name="email" value="{{ old('email') }}" placeholder="your@email.com" required>
          </div>

          <div class="mb-4">
            <label class="form-label fw-bold text-dark mb-2">
              <i class="bi bi-key me-2 text-primary"></i>Password
            </label>
            <div class="input-group">
              <input type="password" class="form-control rounded-start-3 border-2" style="border-color: #e0e0e0; padding: 12px 16px; font-size: 1rem;" name="password" id="passwordLogin" placeholder="Enter password" required>
              <button class="btn btn-outline-secondary rounded-end-3" type="button" id="togglePasswordLogin" style="border-color: #e0e0e0; border-left: none;">
                <i class="bi bi-eye"></i>
              </button>
            </div>
          </div>

          <button type="submit" class="btn w-100 rounded-3 fw-bold" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; color: white; padding: 12px; font-size: 1.1rem;">
            <i class="bi bi-box-arrow-in-right me-2"></i>Log In
          </button>
        </form>

        <div class="text-center mt-4">
          <p class="text-muted mb-0">Don't have an account? 
            <a href="{{ route('task.signup_form') }}" class="fw-bold text-primary text-decoration-none">
              Sign up here
            </a>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  document.getElementById('togglePasswordLogin').addEventListener('click', function() {
    const passwordInput = document.getElementById('passwordLogin');
    const toggleIcon = this.querySelector('i');
    
    if (passwordInput.type === 'password') {
      passwordInput.type = 'text';
      toggleIcon.classList.remove('bi-eye');
      toggleIcon.classList.add('bi-eye-slash');
    } else {
      passwordInput.type = 'password';
      toggleIcon.classList.remove('bi-eye-slash');
      toggleIcon.classList.add('bi-eye');
    }
  });
</script>
@endsection
