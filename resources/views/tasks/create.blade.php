@extends('layout')

@section('content')
<div class="container-fluid py-5" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh;">
  <div class="container">
    <a href="{{ route('task.index') }}" class="btn btn-outline-secondary rounded-pill mb-4">
      <i class="bi bi-arrow-left me-2"></i>Back to Tasks
    </a>

    <div class="row justify-content-center">
      <div class="col-lg-7">
        <div class="card shadow-lg rounded-4 border-0 overflow-hidden">
          <!-- Header -->
          <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);" class="p-5 text-white">
            <h1 class="fw-bold mb-2" style="font-size: 2.2rem;">
              <i class="bi bi-plus-circle me-2"></i>Create New Task
            </h1>
            <p class="mb-0 opacity-85">Add a new task to manage your work</p>
          </div>

          <div class="card-body p-5">
            <!-- Task ID Display -->
            <div class="alert alert-info rounded-3 mb-4" style="background-color: #e7f3ff; border: 2px solid #b3d9ff;">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <p class="text-muted small mb-1">
                    <i class="bi bi-hash me-1"></i>Task ID
                  </p>
                  <h5 class="fw-bold text-dark mb-0" style="font-size: 1.3rem;">
                    <span class="text-primary">#</span><span id="taskId">Auto-generated</span>
                  </h5>
                </div>
                <div>
                  <i class="bi bi-info-circle text-primary" style="font-size: 2rem;"></i>
                </div>
              </div>
              <small class="text-muted d-block mt-2">ID will be assigned after task creation</small>
            </div>

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

            <form action="{{ route('task.store') }}" method="POST" enctype="multipart/form-data">
              @csrf

              <div class="mb-4">
                <label class="form-label fw-bold text-dark mb-2">
                  <i class="bi bi-pencil-square text-primary me-2"></i>Task Title
                </label>
                <input type="text" class="form-control rounded-3 border-2" style="border-color: #e0e0e0; padding: 12px 16px; font-size: 1rem;" name="title" value="{{ old('title') }}" placeholder="Enter task title" required>
              </div>

              <div class="mb-4">
                <label class="form-label fw-bold text-dark mb-2">
                  <i class="bi bi-file-text text-primary me-2"></i>Description
                </label>
                <textarea class="form-control rounded-3 border-2" style="border-color: #e0e0e0; padding: 12px 16px; font-size: 1rem;" name="description" rows="4" placeholder="Enter detailed description">{{ old('description') }}</textarea>
              </div>

              <div class="row">
                <div class="col-md-6 mb-4">
                  <label class="form-label fw-bold text-dark mb-2">
                    <i class="bi bi-calendar-event text-primary me-2"></i>Due Date & Time
                  </label>
                  <input type="datetime-local" class="form-control rounded-3 border-2" style="border-color: #e0e0e0; padding: 12px 16px; font-size: 1rem;" name="due_at" value="{{ old('due_at') }}">
                </div>

                <div class="col-md-6 mb-4">
                  <label class="form-label fw-bold text-dark mb-2">
                    <i class="bi bi-exclamation-circle text-primary me-2"></i>Priority
                  </label>
                  <select class="form-select rounded-3 border-2" style="border-color: #e0e0e0; padding: 12px 16px; font-size: 1rem;" name="priority" required>
                    <option value="">Select Priority</option>
                    <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>🟢 Low</option>
                    <option value="medium" {{ old('priority') === 'medium' ? 'selected' : '' }}>🟡 Medium</option>
                    <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>🔴 High</option>
                  </select>
                </div>
              </div>

              <div class="mb-4">
                <label class="form-label fw-bold text-dark mb-2">
                  <i class="bi bi-tags text-primary me-2"></i>Tags (comma-separated)
                </label>
                <input type="text" class="form-control rounded-3 border-2" style="border-color: #e0e0e0; padding: 12px 16px; font-size: 1rem;" name="tags" value="{{ old('tags') }}" placeholder="e.g., work, urgent, project">
              </div>

              <div class="mb-4">
                <label class="form-label fw-bold text-dark mb-2">
                  <i class="bi bi-paperclip text-primary me-2"></i>Attachment
                </label>
                <input type="file" class="form-control rounded-3 border-2" style="border-color: #e0e0e0; padding: 12px 16px; font-size: 1rem;" name="attachment">
                <small class="text-muted d-block mt-2">
                  <i class="bi bi-info-circle me-1"></i>Max file size: 5MB
                </small>
              </div>

              <div class="d-grid gap-2 pt-3 border-top">
                <button type="submit" class="btn rounded-3 fw-bold" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; color: white; padding: 12px; font-size: 1.1rem;">
                  <i class="bi bi-check-circle me-2"></i>Create Task
                </button>
                <a href="{{ route('task.index') }}" class="btn btn-outline-secondary rounded-3 fw-bold" style="padding: 12px; font-size: 1.1rem;">
                  <i class="bi bi-x-circle me-2"></i>Cancel
                </a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  // Generate a temporary ID preview (will be replaced by actual ID after creation)
  const randomId = Math.floor(Math.random() * 10000) + 1;
  document.getElementById('taskId').textContent = 'New Task';
</script>
@endsection
