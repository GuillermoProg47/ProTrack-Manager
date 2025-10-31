@extends('layouts.app')

@section('title','Edit Task')

@section('content')
<div class="card">
    <div class="card-body">
        <h5>Edit Task</h5>
        <form action="{{ route('admin.tasks.update',$task) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input name="title" class="form-control" value="{{ $task->title }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control">{{ $task->description }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Assign to</label>
                <select name="assigned_to" class="form-select">
                    <option value="">-- none --</option>
                    @foreach($workers as $w)
                        <option value="{{ $w->id }}" {{ $task->assigned_to == $w->id ? 'selected' : '' }}>{{ $w->name }} ({{ $w->email }})</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="pending" {{ $task->status=='pending'?'selected':'' }}>Pending</option>
                    <option value="in-progress" {{ $task->status=='in-progress'?'selected':'' }}>In progress</option>
                    <option value="done" {{ $task->status=='done'?'selected':'' }}>Done</option>
                </select>
            </div>
            <div class="mb-3 d-flex justify-content-between">
                <button class="btn btn-primary">Save</button>
                <a class="btn btn-secondary" href="{{ route('admin.tasks.index') }}">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection
