@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h1 class="h4 mb-0">Crear Nuevo Usuario</h1>
                </div>
                
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <h5 class="alert-heading">Por favor corrige los siguientes errores:</h5>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre:</label>
                            <input type="text" name="name" id="name" class="form-control" 
                                   value="{{ old('name') }}" required placeholder="Ingrese el nombre completo">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" name="email" id="email" class="form-control" 
                                   value="{{ old('email') }}" required placeholder="Ingrese el correo electrónico">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña:</label>
                            <input type="password" name="password" id="password" class="form-control" 
                                   required placeholder="Ingrese una contraseña segura">
                            <div class="form-text">Mínimo 8 caracteres</div>
                        </div>

                        <div class="mb-3">
                            <label for="gender" class="form-label">Género:</label>
                            <select name="gender" id="gender" class="form-select" required>
                                <option value="" disabled selected>Seleccione un género</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Masculino</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Femenino</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="age" class="form-label">Edad:</label>
                            <input type="number" name="age" id="age" class="form-control" 
                                   value="{{ old('age') }}" required min="1" max="120" placeholder="Ingrese la edad">
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary me-md-2 px-4">
                                <i class="bi bi-save-fill"></i> Guardar Usuario
                            </button>
                            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary px-4">
                                <i class="bi bi-x-circle"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection