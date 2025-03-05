@extends('layouts.form')

@section('content')
    <div class="text-center">
        <h1>Bienvenid@ a <span class="criticInicio">Critic</span><span class="criticInicio2">Q</span></h1>
        <p>¿Qué deseas hacer?</p>
        <a href="{{ route('login') }}" class="btn btn-primary">Iniciar Sesión</a>
        <a href="{{ route('registro') }}" class="btn btn-secondary">Registrarse</a>
    </div>
@endsection