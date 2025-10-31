@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-body">
                <h4 class="card-title mb-3">{{ __('Login') }}</h4>

                @if($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email','admin@example.com') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" value="password" required>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <button class="btn btn-primary">{{ __('Login') }}</button>
                        <small class="text-muted">Demo: admin@example.com / password</small>
                    </div>
                </form>
                <div class="mt-3 text-center">
                    <a href="{{ route('register.form') }}">Create an account</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
