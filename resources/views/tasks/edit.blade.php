@extends('layout')

@section('content')
<div class="card shadow-sm mx-auto" style="max-width: 600px;">
    <div class="card-header bg-warning text-dark">
        <h4 class="mb-0">Edit Task</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('task.update', $index) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="{{ $task['title'] }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3" required>{{ $task['description'] }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Due Date</label>
                <input type="date" name="due_date" class="form-control" value="{{ $task['due_date'] }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Due Time</label>
                <input type="time" name="due_time" class="form-control" value="{{ $task['due_time'] }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Priority</label>
                <select name="priority" class="form-select" required>
                    <option value="High" {{ $task['priority']=='High' ? 'selected' : '' }}>High</option>
                    <option value="Medium" {{ $task['priority']=='Medium' ? 'selected' : '' }}>Medium</option>
                    <option value="Low" {{ $task['priority']=='Low' ? 'selected' : '' }}>Low</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Update Task</button>
        </form>
    </div>
</div>
@endsection
