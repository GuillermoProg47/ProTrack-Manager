@extends('layouts.app')

@section('title', 'Editar usuario')

@section('content')
<div class="py-4">
    <div class="container">
        <h2>Editar usuario: {{ $user->name }}</h2>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" class="form-control" value="{{ $user->name }}" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="text" class="form-control" value="{{ $user->email }}" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">Rol</label>
                <select name="role" class="form-select">
                    <option value="user" {{ ($user->role ?? 'user') === 'user' ? 'selected' : '' }}>Usuario</option>
                    <option value="worker" {{ ($user->role ?? 'user') === 'worker' ? 'selected' : '' }}>Trabajador</option>
                    <option value="admin" {{ ($user->role ?? 'user') === 'admin' ? 'selected' : '' }}>Administrador</option>
                </select>
            </div>

            <button class="btn btn-primary">Guardar cambios</button>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@endsection
