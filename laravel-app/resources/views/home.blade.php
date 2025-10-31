@extends('layouts.app')

@section('title', __('messages.home_title'))

@section('content')
<div class="py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>{{ __('messages.welcome') }}</h2>
        <small class="text-muted">{{ ucfirst(app()->getLocale()) }}</small>
    </div>

    <div class="row g-4">
        @foreach($tasks as $task)
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">{{ $task['title'] }}</h5>
                    <p class="card-text">{{ __('messages.status') }}: 
                        @if($task['status'] === 'done')
                            <span class="badge bg-success">{{ __('messages.done') }}</span>
                        @elseif($task['status'] === 'pending')
                            <span class="badge bg-warning">{{ __('messages.pending') }}</span>
                        @else
                            <span class="badge bg-info">{{ __('messages.in_progress') }}</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
