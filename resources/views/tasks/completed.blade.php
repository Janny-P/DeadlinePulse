@extends('layout')

@section('content')
<h2 class="mb-4">Completed Tasks</h2>

@if(count($tasks) == 0)
    <div class="alert alert-info">No completed tasks yet.</div>
@endif

<div class="row g-3">
@foreach($tasks as $index => $task)
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title text-truncate" title="{{ $task['title'] }}">{{ $task['title'] }}</h5>
                <p class="card-text text-truncate" title="{{ $task['description'] }}">{{ $task['description'] }}</p>
                <p><strong>Due:</strong> {{ $task['due_date'] ?? '' }} {{ $task['due_time'] ?? '' }}</p>
                <p>
                    <strong>Status:</strong>
                    <span class="badge badge-completed">Completed</span>
                    <strong>Priority:</strong>
                    <span class="badge 
                        {{ ($task['priority'] ?? 'Low')=='High' ? 'badge-high' : (($task['priority'] ?? 'Low')=='Medium' ? 'badge-medium' : 'badge-low') }}">
                        {{ $task['priority'] ?? 'Low' }}
                    </span>
                </p>
            </div>
            <div class="card-footer text-end">
                <a href="{{ route('task.view', $index) }}" class="btn btn-info btn-sm">View</a>
            </div>
        </div>
    </div>
@endforeach
</div>
@endsection
