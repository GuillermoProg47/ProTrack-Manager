@extends('layouts.app')

@section('title','My Tasks')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>My Tasks</h3>
    <small class="text-muted">{{ session('user.name') }}</small>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row g-3">
    @forelse($tasks as $t)
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $t->title }}</h5>
                <p class="card-text">{{ $t->description }}</p>
                <p><strong>Status:</strong> {{ ucfirst($t->status) }}</p>
                <div class="d-flex justify-content-between">
                    @if($t->status !== 'done')
                        <form method="POST" action="{{ route('tasks.markComplete', $t) }}">
                            @csrf
                            <button class="btn btn-sm btn-success">Mark complete</button>
                        </form>
                    @else
                        <span class="badge bg-success">Completed</span>
                    @endif
                    <small class="text-muted">Due: {{ $t->due_date?->format('Y-m-d') ?? '-' }}</small>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-info">No tasks assigned.</div>
    </div>
    @endforelse
</div>

@endsection
