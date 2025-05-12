@extends('layouts.app')

@section('content')
    <h1>Detalles del Usuario</h1>

    <p><strong>Nombre:</strong> {{ $user->name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Género:</strong> {{ $user->gender }}</p>
    <p><strong>Edad:</strong> {{ $user->age }}</p>

    <a href="{{ route('users.index') }}">Volver</a>
@endsection
