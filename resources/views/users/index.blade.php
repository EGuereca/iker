@extends('layouts.app')

@section('content')
    <h1>Lista de Usuarios</h1>
    <a class="btn btn-outline-success" href="{{ route('users.create') }}">Crear nuevo usuario</a>
    <a class="btn btn-outline-info" href="{{ route('users.stats') }}">Stats</a>
    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Email</th>
                <th scope="col">Género</th>
                <th scope="col">Edad</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>  
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->gender }}</td>
                    <td>{{ $user->age }}</td>
                    <td>
                        <a class="btn btn-outline-primary" href="{{ route('users.show', $user) }}">Ver</a>
                        <a class="btn btn-outline-warning" href="{{ route('users.edit', $user) }}">Editar</a>
                        <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Seguro?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
