@extends('layout')

@section('content')
<div class="container-fluid py-5" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh;">
  <div class="container">
    <a href="{{ route('task.index') }}" class="btn btn-outline-secondary rounded-pill mb-4">
      <i class="bi bi-arrow-left me-2"></i>Back to All Tasks
    </a>
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="card shadow-lg rounded-4 border-0 overflow-hidden">
          <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);" class="p-5 text-white">
            <h1 class="fw-bold mb-2" style="font-size: 2.2rem;">
              <i class="bi bi-check2-circle me-2"></i>Completed Tasks
            </h1>
            <p class="mb-0 opacity-85">All your finished tasks in one place</p>
          </div>
          <div class="card-body p-5">
            @if (session('success'))
              <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            @endif
            @if($tasks->count() > 0)
              <div class="table-responsive">
                <table class="table table-hover align-middle">
                  <thead class="table-light">
                    <tr>
                      <th>Title</th>
                      <th>Description</th>
                      <th>Priority</th>
                      <th>Completed Date</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($tasks as $task)
                      <tr>
                        <td><strong>{{ $task->title }}</strong></td>
                        <td>{{ Str::limit($task->description, 80) }}</td>
                        <td>
                          <span class="badge {{ $task->priority === 'high' ? 'bg-danger' : ($task->priority === 'medium' ? 'bg-warning text-dark' : 'bg-info') }}">
                            {{ ucfirst($task->priority) }}
                          </span>
                        </td>
                        <td>{{ $task->updated_at->format('M d, Y') }}</td>
                        <td>
                          <a href="{{ route('task.show', $task->id) }}" class="btn btn-sm btn-outline-primary rounded-pill me-2">
                            <i class="bi bi-eye"></i> View
                          </a>
                          <a href="{{ route('task.edit', $task->id) }}" class="btn btn-sm btn-outline-warning rounded-pill">
                            <i class="bi bi-pencil"></i> Edit
                          </a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <div class="d-flex justify-content-center mt-4">
                {{ $tasks->links() }}
              </div>
            @else
              <div class="alert alert-info">No completed tasks yet.</div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
