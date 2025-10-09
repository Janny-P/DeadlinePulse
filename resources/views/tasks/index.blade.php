@extends('layout')

@section('content')
<h2 class="mb-4">Task Dashboard</h2>

{{-- Search Form --}}
<form action="{{ route('task.search') }}" method="GET" class="mb-4">
    <div class="input-group">
        <input type="text" name="query" class="form-control" placeholder="Search by title" value="{{ request('query') }}">
        <button type="submit" class="btn btn-primary">Search</button>
    </div>
</form>

{{-- Pending Tasks --}}
<h4 class="mb-3">Pending Tasks</h4>
@if(count($tasks) == 0 || count(array_filter($tasks, fn($t) => !($t['completed'] ?? false))) == 0)
    <div class="alert alert-info">No pending tasks.</div>
@endif

<div class="row g-3">
@foreach($tasks as $index => $task)
    @if(!($task['completed'] ?? false))
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title text-truncate" title="{{ $task['title'] }}">{{ $task['title'] }}</h5>
                <p class="card-text text-truncate" title="{{ $task['description'] }}">{{ $task['description'] }}</p>
                <p><strong>Due:</strong> {{ $task['due_date'] ?? '' }} {{ $task['due_time'] ?? '' }}</p>
                <p>
                    <strong>Status:</strong>
                    <span class="badge badge-pending">Pending</span>
                    <strong>Priority:</strong>
                    <span class="badge 
                        {{ ($task['priority'] ?? 'Low')=='High' ? 'badge-high' : (($task['priority'] ?? 'Low')=='Medium' ? 'badge-medium' : 'badge-low') }}">
                        {{ $task['priority'] ?? 'Low' }}
                    </span>
                </p>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center">
                <div>
                    <a href="{{ route('task.edit', $index) }}" class="btn btn-warning btn-sm">Edit</a>
                    <a href="{{ route('task.delete', $index) }}" class="btn btn-danger btn-sm">Delete</a>
                    <a href="{{ route('task.complete', $index) }}" class="btn btn-success btn-sm">Complete</a>
                </div>
                <div>
                    <a href="{{ route('task.view', $index) }}" class="btn btn-info btn-sm">View</a>
                </div>
            </div>
        </div>
    </div>
    @endif
@endforeach
</div>
@endsection
