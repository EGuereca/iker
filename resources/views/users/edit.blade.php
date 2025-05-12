@extends('layouts.app')

@section('content')
    <h1>Editar Usuario</h1>

    @if ($errors->any())
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Nombre:</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}" required><br>

        <label>Email:</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" required><br>

        <label>Contraseña (dejar vacío si no se cambia):</label>
        <input type="password" name="password"><br>

        <label>Género:</label>
        <select name="gender" required>
            <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>Masculino</option>
            <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>Femenino</option>
        </select><br>
        <label>Edad:</label>
        <input type="number" name="age" value="{{ old('age', $user->age) }}" required><br>

        <button type="submit">Actualizar</button>
    </form>
@endsection
