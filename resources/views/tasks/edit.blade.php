@extends('layout')

@section('content')
<div class="container-fluid py-5" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh;">
  <div class="container">
    <a href="{{ route('task.show', $task->id) }}" class="btn btn-outline-secondary rounded-pill mb-4">
      <i class="bi bi-arrow-left me-2"></i>Back to Task
    </a>
    <div class="row justify-content-center">
      <div class="col-lg-7">
        <div class="card shadow-lg rounded-4 border-0 overflow-hidden">
          <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);" class="p-5 text-white">
            <h1 class="fw-bold mb-2" style="font-size: 2.2rem;">
              <i class="bi bi-pencil-square me-2"></i>Edit Task
            </h1>
            <p class="mb-0 opacity-85">Update your task details</p>
          </div>
          <div class="card-body p-5">
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
            <form action="{{ route('task.update', $task->id) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <div class="mb-4">
                <label class="form-label fw-bold text-dark mb-2">
                  <i class="bi bi-pencil-square text-primary me-2"></i>Task Title
                </label>
                <input type="text" class="form-control rounded-3 border-2" style="border-color: #e0e0e0; padding: 12px 16px; font-size: 1rem;" name="title" value="{{ $task->title }}" required>
              </div>
              <div class="mb-4">
                <label class="form-label fw-bold text-dark mb-2">
                  <i class="bi bi-file-text text-primary me-2"></i>Description
                </label>
                <textarea class="form-control rounded-3 border-2" style="border-color: #e0e0e0; padding: 12px 16px; font-size: 1rem;" name="description" rows="4">{{ $task->description }}</textarea>
              </div>
              <div class="row">
                <div class="col-md-6 mb-4">
                  <label class="form-label fw-bold text-dark mb-2">
                    <i class="bi bi-calendar-event text-primary me-2"></i>Due Date & Time
                  </label>
                  <input type="datetime-local" class="form-control rounded-3 border-2" style="border-color: #e0e0e0; padding: 12px 16px; font-size: 1rem;" name="due_at" value="{{ $task->due_at ? $task->due_at->format('Y-m-d\TH:i') : '' }}">
                </div>
                <div class="col-md-6 mb-4">
                  <label class="form-label fw-bold text-dark mb-2">
                    <i class="bi bi-exclamation-circle text-primary me-2"></i>Priority
                  </label>
                  <select class="form-select rounded-3 border-2" style="border-color: #e0e0e0; padding: 12px 16px; font-size: 1rem;" name="priority" required>
                    <option value="low" {{ $task->priority === 'low' ? 'selected' : '' }}>🟢 Low</option>
                    <option value="medium" {{ $task->priority === 'medium' ? 'selected' : '' }}>🟡 Medium</option>
                    <option value="high" {{ $task->priority === 'high' ? 'selected' : '' }}>🔴 High</option>
                  </select>
                </div>
              </div>
              <div class="mb-4">
                <label class="form-label fw-bold text-dark mb-2">
                  <i class="bi bi-flag text-primary me-2"></i>Status
                </label>
                <select class="form-select rounded-3 border-2" style="border-color: #e0e0e0; padding: 12px 16px; font-size: 1rem;" name="status" required>
                  <option value="pending" {{ $task->status === 'pending' ? 'selected' : '' }}>Pending</option>
                  <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                  <option value="completed" {{ $task->status === 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
              </div>
              <div class="mb-4">
                <label class="form-label fw-bold text-dark mb-2">
                  <i class="bi bi-tags text-primary me-2"></i>Tags (comma-separated)
                </label>
                <input type="text" class="form-control rounded-3 border-2" style="border-color: #e0e0e0; padding: 12px 16px; font-size: 1rem;" name="tags" value="{{ implode(', ', $task->tags ?? []) }}" placeholder="e.g., work, urgent, project">
              </div>
              <div class="mb-4">
                <label class="form-label fw-bold text-dark mb-2">
                  <i class="bi bi-paperclip text-primary me-2"></i>Attachment
                </label>
                <input type="file" class="form-control rounded-3 border-2" style="border-color: #e0e0e0; padding: 12px 16px; font-size: 1rem;" name="attachment">
                <small class="text-muted d-block mt-2">
                  <i class="bi bi-info-circle me-1"></i>Max file size: 5MB. Leave empty to keep current attachment.
                </small>
                @if($task->attachment)
                  <p class="mt-2"><strong>Current:</strong> <a href="{{ asset('storage/' . $task->attachment) }}" target="_blank">View</a></p>
                @endif
              </div>
              <div class="d-grid gap-2 pt-3 border-top">
                <button type="submit" class="btn rounded-3 fw-bold" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; color: white; padding: 12px; font-size: 1.1rem;">
                  <i class="bi bi-check-circle me-2"></i>Update Task
                </button>
                <a href="{{ route('task.show', $task->id) }}" class="btn btn-outline-secondary rounded-3 fw-bold" style="padding: 12px; font-size: 1.1rem;">
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
@endsection
