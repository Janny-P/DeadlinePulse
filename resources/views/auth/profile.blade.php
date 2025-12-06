@extends('layout')

@section('content')
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-6">
      <!-- Profile Header Card -->
      <div class="card shadow-lg border-0 rounded-4 overflow-hidden mb-4">
        <div class="bg-gradient p-5 text-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
          <h1 class="text-white mb-0" style="font-size: 2.5rem;">Profile Settings</h1>
        </div>

        @if (session('success'))
          <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif

        @if ($errors->any())
          <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif

        <form action="{{ route('task.profile_update') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="card-body p-5">
            
            <!-- Avatar Section -->
            <div class="text-center mb-5">
              <div class="position-relative d-inline-block">
                @if ($user->avatar)
                  <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" 
                       class="rounded-circle border-4 border-primary" 
                       style="width: 150px; height: 150px; object-fit: cover; border-color: #667eea !important;">
                @else
                  <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" 
                       style="width: 150px; height: 150px; border: 4px solid #667eea;">
                    <i class="bi bi-person-fill text-secondary" style="font-size: 3rem;"></i>
                  </div>
                @endif
                
                <!-- Upload Badge -->
                <label for="avatar" class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-3" 
                       style="cursor: pointer; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0,0,0,0.2);">
                  <i class="bi bi-camera-fill" style="font-size: 1.2rem;"></i>
                </label>
              </div>
              
              <input type="file" id="avatar" name="avatar" accept="image/*" class="d-none" onchange="previewImage(this)">
              <p class="text-muted mt-3 mb-0"><small>Click camera icon to change avatar</small></p>
            </div>

            <!-- Form Fields -->
            <div class="mb-4">
              <label class="form-label fw-bold text-dark" style="font-size: 1.1rem;">
                <i class="bi bi-person-fill text-primary me-2"></i>Full Name
              </label>
              <input type="text" class="form-control form-control-lg rounded-3 border-2" 
                     name="name" value="{{ $user->name }}" required
                     style="border-color: #e0e0e0; padding: 12px 20px; font-size: 1rem;">
            </div>

            <div class="mb-5">
              <label class="form-label fw-bold text-dark" style="font-size: 1.1rem;">
                <i class="bi bi-envelope-fill text-primary me-2"></i>Email Address
              </label>
              <input type="email" class="form-control form-control-lg rounded-3 border-2" 
                     name="email" value="{{ $user->email }}" required
                     style="border-color: #e0e0e0; padding: 12px 20px; font-size: 1rem;">
              <small class="text-muted d-block mt-2">We'll use this email for important notifications</small>
            </div>

            <!-- Action Buttons -->
            <div class="d-grid gap-3">
              <button type="submit" class="btn btn-primary btn-lg rounded-3 fw-bold" 
                      style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; padding: 14px; font-size: 1.1rem; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);">
                <i class="bi bi-check-circle me-2"></i>Save Changes
              </button>
              
              <a href="{{ route('task.index') }}" class="btn btn-outline-secondary btn-lg rounded-3 fw-bold" 
                 style="padding: 14px; font-size: 1.1rem; border-width: 2px;">
                <i class="bi bi-arrow-left me-2"></i>Back to Tasks
              </a>
            </div>
          </div>
        </form>
      </div>

      <!-- Profile Info Card -->
      <div class="card shadow-sm border-0 rounded-4 p-4 text-center">
        <p class="text-muted mb-2"><small>Member since {{ $user->created_at->format('M d, Y') }}</small></p>
        <p class="text-muted mb-0"><small>Last updated: {{ $user->updated_at->format('M d, Y h:i A') }}</small></p>
      </div>
    </div>
  </div>
</div>

<script>
function previewImage(input) {
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function(e) {
      document.querySelector('.rounded-circle').src = e.target.result;
    };
    reader.readAsDataURL(input.files[0]);
  }
}
</script>
@endsection
