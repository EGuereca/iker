@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h1 class="h4 mb-0">Detalles del Usuario</h1>
                </div>
                
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4 text-center">
                            <div class="avatar-placeholder bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto" 
                                 style="width: 120px; height: 120px; font-size: 3rem;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="user-details">
                                <div class="mb-3">
                                    <h5 class="text-muted mb-1">Nombre completo</h5>
                                    <p class="h4">{{ $user->name }}</p>
                                </div>
                                
                                <div class="mb-3">
                                    <h5 class="text-muted mb-1">Correo electrónico</h5>
                                    <p class="h5">{{ $user->email }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title text-muted">Información Personal</h5>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>Género</span>
                                            <span class="badge bg-primary rounded-pill">
                                                {{ $user->gender == 'male' ? 'Masculino' : 'Femenino' }}
                                            </span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>Edad</span>
                                            <span class="badge bg-info rounded-pill">{{ $user->age }} años</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title text-muted">Estadísticas</h5>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>Miembro desde</span>
                                            <span class="text-muted">{{ $user->created_at->format('d/m/Y') }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>Última actualización</span>
                                            <span class="text-muted">{{ $user->updated_at->format('d/m/Y') }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('users.index') }}" class="btn btn-outline-primary">
                            <i class="bi bi-arrow-left"></i> Volver al listado
                        </a>
                        <div>
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-warning me-2">
                                <i class="bi bi-pencil"></i> Editar
                            </a>
                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">
                                    <i class="bi bi-trash"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection