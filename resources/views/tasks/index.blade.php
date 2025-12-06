@extends('layout')

@section('content')
<div class="container-fluid py-5" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh;">
  <div class="container">
    <!-- Header Section -->
    <div class="row align-items-center mb-5">
      <div class="col-md-8">
        <h1 class="display-4 fw-bold text-dark mb-2">
          <i class="bi bi-check2-square text-primary me-3"></i>Task Dashboard
        </h1>
        <p class="text-muted lead mb-0">Organize and manage your tasks efficiently</p>
      </div>
      <div class="col-md-4 text-end">
        @if(session('logged_in'))
          <a href="{{ route('task.create') }}" class="btn btn-primary btn-lg rounded-pill shadow" 
             style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; padding: 12px 30px;">
            <i class="bi bi-plus-circle me-2"></i>Add New Task
          </a>
        @else
          <a href="{{ route('task.login_form') }}" class="btn btn-primary btn-lg rounded-pill shadow">
            <i class="bi bi-lock me-2"></i>Login to Add Task
          </a>
        @endif
      </div>
    </div>

    @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-4" role="alert">
        <i class="bi bi-check-circle me-2"></i><strong>Success!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <!-- Search & Filter Section -->
    <div class="card shadow-lg rounded-4 border-0 mb-4 overflow-hidden">
      <div class="card-body p-4">
        <form method="GET" class="row g-3">
          <div class="col-md-3">
            <label class="form-label fw-bold text-dark mb-2">
              <i class="bi bi-search me-2 text-primary"></i>Search
            </label>
            <input type="text" name="search" value="{{ $search ?? '' }}" 
                   class="form-control rounded-3 border-2" 
                   placeholder="Search by title..."
                   style="border-color: #e0e0e0; padding: 10px 18px;">
          </div>
          
          <div class="col-md-2">
            <label class="form-label fw-bold text-dark mb-2">
              <i class="bi bi-funnel me-2 text-primary"></i>Status
            </label>
            <select name="status" class="form-select rounded-3 border-2" style="border-color: #e0e0e0; padding: 10px 18px;">
              <option value="">All Status</option>
              <option value="pending" {{ ($status ?? '') === 'pending' ? 'selected' : '' }}>
                <i class="bi bi-clock me-1"></i>Pending
              </option>
              <option value="in_progress" {{ ($status ?? '') === 'in_progress' ? 'selected' : '' }}>
                <i class="bi bi-play-circle me-1"></i>In Progress
              </option>
              <option value="completed" {{ ($status ?? '') === 'completed' ? 'selected' : '' }}>
                <i class="bi bi-check-circle me-1"></i>Completed
              </option>
            </select>
          </div>

          <div class="col-md-2">
            <label class="form-label fw-bold text-dark mb-2">
              <i class="bi bi-exclamation-circle me-2 text-primary"></i>Priority
            </label>
            <select name="priority" class="form-select rounded-3 border-2" style="border-color: #e0e0e0; padding: 10px 18px;">
              <option value="">All Priority</option>
              <option value="low" {{ ($priority ?? '') === 'low' ? 'selected' : '' }}>🟢 Low</option>
              <option value="medium" {{ ($priority ?? '') === 'medium' ? 'selected' : '' }}>🟡 Medium</option>
              <option value="high" {{ ($priority ?? '') === 'high' ? 'selected' : '' }}>🔴 High</option>
            </select>
          </div>

          <div class="col-md-2">
            <label class="form-label fw-bold text-dark mb-2">
              <i class="bi bi-calendar me-2 text-primary"></i>Due Date
            </label>
            <input type="date" name="due_date" value="{{ $due_date ?? '' }}" 
                   class="form-control rounded-3 border-2" 
                   style="border-color: #e0e0e0; padding: 10px 18px;">
          </div>

          <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100 rounded-3 fw-bold" 
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; padding: 10px 18px;">
              <i class="bi bi-search me-2"></i>Apply Filters
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Tasks Grid -->
    @if($tasks->count() > 0)
      <div class="row g-4 mb-5">
        @foreach($tasks as $task)
          <div class="col-lg-6">
            <div class="card shadow-lg rounded-4 border-0 transition" style="transition: all 0.3s ease; display: flex; flex-direction: column;">
              <div class="card-body p-4 d-flex flex-column flex-grow-1">
                <!-- Task Header with Title on Top Right -->
                <div class="d-flex justify-content-between align-items-start mb-2">
                  <div class="flex-grow-1">
                    <p class="text-muted small mb-0">
                      <i class="bi bi-calendar3 me-1"></i>
                      {{ $task->due_at ? $task->due_at->format('M d, Y') : 'No due date' }}
                    </p>
                  </div>
                  <div>
                    <span class="badge rounded-pill {{ $task->status === 'completed' ? 'bg-success' : ($task->status === 'in_progress' ? 'bg-warning text-dark' : 'bg-secondary') }}" 
                          style="padding: 8px 14px; font-size: 0.85rem; white-space: nowrap;">
                      {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                    </span>
                  </div>
                </div>

                <!-- Task Title -->
                <h5 class="card-title fw-bold text-dark mb-2" style="font-size: 1.3rem; line-height: 1.4;">
                  <a href="{{ route('task.show', $task->id) }}" class="text-decoration-none text-dark hover-primary">
                    {{ Str::limit($task->title, 50) }}
                  </a>
                </h5>

                <!-- Task Description - Fixed Height -->
                <div class="mb-2" style="min-height: 80px; max-height: 80px; overflow: hidden;">
                  <p class="card-text text-muted" style="margin: 0; line-height: 1.5;">
                    {{ $task->description ? Str::limit($task->description, 150) : '<em>No description</em>' }}
                  </p>
                </div>

                <!-- Priority & Tags - Fixed Height -->
                <div class="mb-2" style="min-height: 60px;">
                  <span class="badge rounded-pill {{ $task->priority === 'high' ? 'bg-danger' : ($task->priority === 'medium' ? 'bg-warning text-dark' : 'bg-info') }}" 
                        style="padding: 6px 12px; font-size: 0.8rem;">
                    <i class="bi bi-exclamation-circle me-1"></i>{{ ucfirst($task->priority) }} Priority
                  </span>
                  
                  @if($task->tags)
                    <div class="mt-2">
                      @foreach($task->tags as $tag)
                        <span class="badge bg-light text-dark rounded-pill me-1" style="padding: 6px 12px; font-size: 0.8rem;">
                          <i class="bi bi-tag me-1"></i>{{ $tag }}
                        </span>
                      @endforeach
                    </div>
                  @endif
                </div>

                <!-- Attachment Section - Fixed Height -->
                <div style="margin-bottom: 5px; height: 50px; display: flex; align-items: center;">
                  @if($task->attachment)
                    <div class="alert alert-info rounded-3 py-2 px-3 mb-0 w-100" style="background-color: #e7f3ff; border: 1px solid #b3d9ff; font-size: 0.9rem;">
                      <div class="d-flex justify-content-between align-items-center">
                        <div>
                          <i class="bi bi-paperclip me-2 text-primary"></i>
                          <strong class="text-dark">Attachment</strong>
                        </div>
                        <div class="d-flex gap-2">
                          <a href="{{ route('task.view_attachment', $task->id) }}" class="btn btn-sm btn-outline-info rounded-2" title="View" target="_blank">
                            <i class="bi bi-eye"></i>
                          </a>
                          <a href="{{ route('task.download', $task->id) }}" class="btn btn-sm btn-outline-info rounded-2" title="Download">
                            <i class="bi bi-download"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  @else
                    <div class="alert alert-secondary rounded-3 py-2 px-3 mb-0 w-100" style="background-color: #f0f0f0; border: 1px solid #d0d0d0; font-size: 0.9rem;">
                      <i class="bi bi-paperclip me-2 text-muted"></i>
                      <span class="text-muted">
                        <em>No attachments</em>
                      </span>
                    </div>
                  @endif
                </div>

                <!-- Action Buttons - Always at Bottom -->
                <div style="margin-top: 5px; padding-top: 8px; border-top: 1px solid #e0e0e0;">
                  @if(session('logged_in') && session('user_id') == $task->user_id)
                    <div class="d-flex gap-2">
                      <a href="{{ route('task.show', $task->id) }}" class="btn btn-sm btn-outline-primary rounded-pill flex-grow-1">
                        <i class="bi bi-eye me-1"></i>View
                      </a>
                      <a href="{{ route('task.edit', $task->id) }}" class="btn btn-sm btn-outline-warning rounded-pill flex-grow-1">
                        <i class="bi bi-pencil me-1"></i>Edit
                      </a>
                      <form action="{{ route('task.delete', $task->id) }}" method="POST" style="display:inline; flex-grow: 1;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill w-100" 
                                onclick="return confirm('Delete this task?')">
                          <i class="bi bi-trash me-1"></i>Delete
                        </button>
                      </form>
                    </div>
                  @else
                    <a href="{{ route('task.show', $task->id) }}" class="btn btn-sm btn-outline-primary rounded-pill w-100">
                      <i class="bi bi-eye me-2"></i>View Task
                    </a>
                  @endif
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      <!-- Pagination -->
      <div class="d-flex justify-content-center mb-5">
        {{ $tasks->links('pagination::bootstrap-5') }}
      </div>
    @else
      <div class="card shadow-lg rounded-4 border-0 text-center py-5">
        <div class="card-body">
          <i class="bi bi-inbox" style="font-size: 4rem; color: #ccc;"></i>
          <h4 class="mt-3 text-dark">No Tasks Found</h4>
          <p class="text-muted mb-3">Start by creating a new task to organize your work</p>
          @if(session('logged_in'))
            <a href="{{ route('task.create') }}" class="btn btn-primary rounded-pill" 
               style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
              <i class="bi bi-plus-circle me-2"></i>Create Your First Task
            </a>
          @else
            <a href="{{ route('task.login_form') }}" class="btn btn-primary rounded-pill">
              <i class="bi bi-lock me-2"></i>Login to Get Started
            </a>
          @endif
        </div>
      </div>
    @endif
  </div>
</div>

<style>
.transition {
  transition: all 0.3s ease;
}
.transition:hover {
  transform: translateY(-5px);
  box-shadow: 0 15px 40px rgba(102, 126, 234, 0.2) !important;
}
.hover-primary:hover {
  color: #667eea !important;
}
</style>
@endsection
