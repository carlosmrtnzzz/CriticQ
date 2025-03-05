@extends('layouts.form')

@section('titulo', 'Registro')

@section('content')
    <div class="form-container">
        <h2 class="form-title text-center">Crear Cuenta</h2>
        <form action="{{ route('register.post') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <input type="text" name="username" class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}"
                    placeholder="Nombre de usuario" value="{{ old('username') }}">
                @if($errors->has('username'))
                    <div class="error-message">{{ $errors->first('username') }}</div>
                @endif
            </div>
            <div class="form-group">
                <input type="text" name="nombre" class="form-control {{ $errors->has('nombre') ? 'is-invalid' : '' }}"
                    placeholder="Nombre" value="{{ old('nombre') }}">
                @if($errors->has('nombre'))
                    <div class="error-message">{{ $errors->first('nombre') }}</div>
                @endif
            </div>
            <div class="form-group">
                <input type="text" name="apellido" class="form-control {{ $errors->has('apellido') ? 'is-invalid' : '' }}"
                    placeholder="Apellido" value="{{ old('apellido') }}">
                @if($errors->has('apellido'))
                    <div class="error-message">{{ $errors->first('apellido') }}</div>
                @endif
            </div>
            <div class="form-group">
                <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                    placeholder="Correo electrónico" value="{{ old('email') }}">
                @if($errors->has('email'))
                    <div class="error-message">{{ $errors->first('email') }}</div>
                @endif
            </div>
            <div class="form-group">
                <input type="password" name="password"
                    class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" placeholder="Contraseña">
                @if($errors->has('password'))
                    <div class="error-message">{{ $errors->first('password') }}</div>
                @endif
            </div>
            <div class="form-group">
                <input type="password" name="password_confirmation"
                    class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                    placeholder="Confirmar contraseña">
            </div>
            <div class="file-input-container">
                <label class="file-input-label">
                    Seleccionar avatar
                    <input type="file" name="avatar" class="file-input {{ $errors->has('avatar') ? 'is-invalid' : '' }}">
                </label>
                <div class="file-name" id="fileName">Ningún archivo seleccionado</div>
                @if($errors->has('avatar'))
                    <div class="error-message">{{ $errors->first('avatar') }}</div>
                @endif
            </div>
            <button type="submit" class="form-button">Registrarse</button>
            <a href="{{ route('login') }}" class="form-link text-center">¿Ya tienes cuenta? Inicia sesión</a>
        </form>
    </div>

    <script src="{{ asset('js/extra/cambiarFileInput.js') }}"></script>
    <script src="{{ asset('js/registro/validarRegistro.js') }}"></script>
    <script src="{{ asset('js/registro/verContraseña.js') }}"></script>
@endsection