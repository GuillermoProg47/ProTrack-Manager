@extends('layouts.app')

@section('title','Create Task')

@section('content')
<div class="card">
    <div class="card-body">
        <h5>Create Task</h5>
        <form action="{{ route('admin.tasks.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input name="title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Assign to</label>
                <select name="assigned_to" class="form-select">
                    <option value="">-- none --</option>
                    @foreach($workers as $w)
                        <option value="{{ $w->id }}">{{ $w->name }} ({{ $w->email }})</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3 d-flex justify-content-between">
                <button class="btn btn-primary">Create</button>
                <a class="btn btn-secondary" href="{{ route('admin.tasks.index') }}">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection
