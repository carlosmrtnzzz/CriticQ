@extends('layouts.form')

@section('titulo', 'Login')

@section('content')
    <div class="form-container">
        <h2 class="form-title text-center">Iniciar Sesión</h2>
        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Correo electrónico" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
            </div>
            <button type="submit" class="form-button">Iniciar Sesión</button>
            <a href="{{ route('registro') }}" class="form-link text-center">¿No tienes cuenta? Regístrate</a>
        </form>
        @if ($errors->any())
            <div class="error-message">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    </div>
    <script src="{{ asset('js/registro/verContraseña.js') }}"></script>

@endsection