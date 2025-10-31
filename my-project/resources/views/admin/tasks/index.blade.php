@extends('layouts.app')

@section('title','Tasks')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Tasks</h3>
    <a href="{{ route('admin.tasks.create') }}" class="btn btn-primary">Create Task</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Assigned</th>
            <th>Status</th>
            <th>Due</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($tasks as $t)
        <tr>
            <td>{{ $t->id }}</td>
            <td>{{ $t->title }}</td>
            <td>{{ $t->assigned->name ?? '-' }}</td>
            <td>{{ ucfirst($t->status) }}</td>
            <td>{{ $t->due_date?->format('Y-m-d') }}</td>
            <td class="text-end">
                <a href="{{ route('admin.tasks.edit', $t) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                <form action="{{ route('admin.tasks.destroy', $t) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Delete task?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
