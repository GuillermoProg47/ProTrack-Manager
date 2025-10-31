@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Admin Dashboard</h2>
        <div class="d-flex align-items-center">
            <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-success me-2">Crear usuario</a>
            <div class="text-end">
                <small class="text-muted">{{ session('user.name') }}</small><br>
                <small class="text-muted">{{ session('user.email') ?? '' }} • rol: {{ session('user.role') ?? 'n/a' }}</small>
            </div>
        </div>
    </div>

    @if(config('app.debug'))
    <div class="mb-3">
        <div class="alert alert-info p-2 small">DEBUG: sesión: {{ json_encode(session('user')) }}</div>
    </div>
    @endif

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Users</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $u)
                        <tr>
                            <td>{{ $u->id }}</td>
                            <td>{{ $u->name }}</td>
                            <td>{{ $u->email }}</td>
                            <td>{{ $u->role ?? 'user' }}</td>
                            <td>{{ $u->created_at->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('admin.users.edit', $u) }}" class="btn btn-sm btn-primary">Editar</a>

                                <form action="{{ route('admin.users.destroy', $u) }}" method="POST" style="display:inline" onsubmit="return confirm('¿Eliminar usuario? Esta acción no es reversible.');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Eliminar</button>
                                </form>

                                <form action="{{ route('admin.users.toggleActive', $u) }}" method="POST" style="display:inline;margin-left:6px;">
                                    @csrf
                                    <button class="btn btn-sm btn-{{ ($u->active ?? true) ? 'warning' : 'success' }}">{{ ($u->active ?? true) ? 'Desactivar' : 'Activar' }}</button>
                                </form>

                                <form action="{{ route('admin.users.resetPassword', $u) }}" method="POST" style="display:inline;margin-left:6px;" onsubmit="return confirm('Resetear la contraseña de este usuario a "secret"?');">
                                    @csrf
                                    <button class="btn btn-sm btn-secondary">Reset Pass</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
