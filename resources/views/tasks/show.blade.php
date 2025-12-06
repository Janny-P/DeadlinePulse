@extends('layout')

@section('content')
<div class="container-fluid py-5" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh;">
  <div class="container">
    <a href="{{ route('task.index') }}" class="btn btn-outline-secondary rounded-pill mb-4">
      <i class="bi bi-arrow-left me-2"></i>Back to Tasks
    </a>

    <div class="row g-4">
      <!-- Main Task Details -->
      <div class="col-lg-8">
        <div class="card shadow-lg rounded-4 border-0 mb-4 overflow-hidden">
          <!-- Header with Status -->
          <div class="bg-gradient p-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="d-flex justify-content-between align-items-start">
              <div class="flex-grow-1">
                <h2 class="fw-bold mb-3" style="font-size: 1.8rem; line-height: 1.3; color: #000;">{{ $task->title }}</h2>
                <p class="lead mb-0" style="font-size: 1.2rem; color: #000;">
                  <i class="bi bi-calendar3 me-2"></i>
                  {{ $task->due_at ? $task->due_at->format('M d, Y h:i A') : 'No due date' }}
                </p>
              </div>
              <div>
                <span class="badge rounded-pill bg-light text-dark" style="padding: 12px 20px; font-size: 1rem;">
                  <i class="bi bi-info-circle me-2"></i>{{ ucfirst(str_replace('_', ' ', $task->status)) }}
                </span>
              </div>
            </div>
          </div>

          <!-- Task Content -->
          <div class="card-body p-5">
            <!-- Description -->
            <div class="mb-5">
              <h5 class="fw-bold text-dark mb-3">
                <i class="bi bi-file-text text-primary me-2"></i>Description
              </h5>
              <div class="description-scroll">
                <p class="text-muted" style="font-size: 1.25rem; line-height: 1.8; margin-bottom: 0;">{{ $task->description ?: 'No description provided' }}</p>
              </div>
            </div>

            <!-- Metadata Grid -->
            <div class="row g-4 mb-5">
              <div class="col-md-6">
                <div class="p-4 rounded-4 bg-light">
                  <p class="text-muted small mb-2">
                    <i class="bi bi-exclamation-circle text-warning me-2"></i>Priority Level
                  </p>
                  <span class="badge rounded-pill {{ $task->priority === 'high' ? 'bg-danger' : ($task->priority === 'medium' ? 'bg-warning text-dark' : 'bg-info') }}" 
                        style="padding: 10px 18px; font-size: 0.95rem;">
                    {{ ucfirst($task->priority) }} Priority
                  </span>
                </div>
              </div>
              <div class="col-md-6">
                <div class="p-4 rounded-4 bg-light">
                  <p class="text-muted small mb-2">
                    <i class="bi bi-calendar-check text-success me-2"></i>Task Status
                  </p>
                  <span class="badge rounded-pill {{ $task->status === 'completed' ? 'bg-success' : ($task->status === 'in_progress' ? 'bg-warning text-dark' : 'bg-secondary') }}" 
                        style="padding: 10px 18px; font-size: 0.95rem;">
                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                  </span>
                </div>
              </div>
            </div>

            <!-- Tags -->
            @if($task->tags && count($task->tags) > 0)
              <div class="mb-5">
                <h5 class="fw-bold text-dark mb-3">
                  <i class="bi bi-tags text-primary me-2"></i>Tags
                </h5>
                <div class="d-flex flex-wrap gap-2">
                  @foreach($task->tags as $tag)
                    <span class="badge bg-light text-dark rounded-pill" style="padding: 10px 16px; font-size: 0.9rem;">
                      <i class="bi bi-tag me-1"></i>{{ $tag }}
                    </span>
                  @endforeach
                </div>
              </div>
            @endif

            <!-- Attachment Section -->
            @if($task->attachment)
              <div class="alert alert-info rounded-4 p-4 mb-3" style="background: linear-gradient(135deg, #e7f3ff 0%, #f0e6ff 100%); border: 2px solid #b3d9ff;">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <h6 class="fw-bold text-dark mb-1">
                      <i class="bi bi-paperclip me-2 text-primary"></i>Attachment Available
                    </h6>
                    <p class="text-muted small mb-0">Download the attached file to view details</p>
                  </div>
                  <a href="{{ route('task.download', $task->id) }}" class="btn btn-primary rounded-pill" 
                     style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                    <i class="bi bi-download me-2"></i>Download File
                  </a>
                </div>
              </div>
            @else
              <div class="alert alert-secondary rounded-4 p-4 mb-3" style="background-color: #f0f0f0; border: 2px solid #d0d0d0;">
                <div class="d-flex align-items-center">
                  <div>
                    <h6 class="fw-bold text-muted mb-1">
                      <i class="bi bi-paperclip me-2"></i>No Attachments
                    </h6>
                    <p class="text-muted small mb-0">This task does not have any attached files</p>
                  </div>
                </div>
              </div>
            @endif

            <!-- Timestamps -->
            <div class="border-top pt-4 text-muted small">
              <p class="mb-1"><i class="bi bi-calendar-plus me-2"></i><strong>Created:</strong> {{ $task->created_at->format('M d, Y h:i A') }}</p>
              <p class="mb-0"><i class="bi bi-pencil-square me-2"></i><strong>Last Updated:</strong> {{ $task->updated_at->format('M d, Y h:i A') }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Sidebar - Actions -->
      <div class="col-lg-4">
        @if(session('logged_in') && session('user_id') == $task->user_id)
          <div class="card shadow-lg rounded-4 border-0 mb-4 sticky-top" style="top: 20px;">
            <div class="card-body p-4">
              <h6 class="fw-bold text-dark mb-4">
                <i class="bi bi-tools text-primary me-2"></i>Task Actions
              </h6>

              <!-- Update Status -->
              <form action="{{ route('task.toggle', $task->id) }}" method="POST" class="mb-3">
                @csrf
                <label class="form-label fw-bold small text-dark">Change Status</label>
                <select name="status" class="form-select rounded-3 mb-3" 
                        style="border-color: #e0e0e0; padding: 10px 14px;"
                        onchange="this.form.submit()">
                  <option value="pending" {{ $task->status === 'pending' ? 'selected' : '' }}>
                    <i class="bi bi-clock me-1"></i>Pending
                  </option>
                  <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>
                    <i class="bi bi-play-circle me-1"></i>In Progress
                  </option>
                  <option value="completed" {{ $task->status === 'completed' ? 'selected' : '' }}>
                    <i class="bi bi-check-circle me-1"></i>Completed
                  </option>
                </select>
              </form>

              <div class="d-grid gap-2">
                <a href="{{ route('task.edit', $task->id) }}" class="btn btn-warning rounded-3 fw-bold">
                  <i class="bi bi-pencil me-2"></i>Edit Task
                </a>
                <form action="{{ route('task.delete', $task->id) }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger w-100 rounded-3 fw-bold" 
                          onclick="return confirm('Are you sure you want to delete this task?')">
                    <i class="bi bi-trash me-2"></i>Delete Task
                  </button>
                </form>
              </div>
            </div>
          </div>

          <!-- Task Info Card -->
          <div class="card shadow-lg rounded-4 border-0">
            <div class="card-body p-4">
              <h6 class="fw-bold text-dark mb-3">
                <i class="bi bi-info-circle text-primary me-2"></i>Task Info
              </h6>
              <div class="text-muted small">
                <p class="mb-2">
                  <strong>ID:</strong> #{{ $task->id }}
                </p>
                <p class="mb-0">
                  <strong>Created by:</strong> You
                </p>
              </div>
            </div>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
