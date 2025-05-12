@extends('layouts.app')

@section('content')
    <h1>Crear Usuario</h1>

    @if ($errors->any())
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <label>Nombre:</label>
        <input type="text" name="name" value="{{ old('name') }}" required><br>

        <label>Email:</label>
        <input type="email" name="email" value="{{ old('email') }}" required><br>

        <label>Contraseña:</label>
        <input type="password" name="password" required><br>

        <label>Género:</label>
        <select name="gender" required>
            <option value="male">Masculino</option>
            <option value="female">Femenino</option>
        </select><br>
        <label>Edad:</label>
        <input type="number" name="age" value="{{ old('age') }}" required><br>

        <button type="submit">Guardar</button>
    </form>
@endsection
