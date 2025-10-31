@extends('layouts.app')

@section('title', 'Worker Dashboard')

@section('content')
<div class="py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Worker Dashboard</h2>
        <small class="text-muted">{{ session('user.name') }}</small>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Assigned tasks</h5>
                    <p class="card-text">This is a placeholder for worker-specific tasks and tools.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-body">
                    <h6>Quick actions</h6>
                    <ul class="list-unstyled">
                        <li><a href="#">Start shift</a></li>
                        <li><a href="#">View schedule</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
