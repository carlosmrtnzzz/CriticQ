@extends('layouts.base')

@section('titulo', 'Perfil de ' . $usuario->username)
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
    <div class="container mt-5">
        <h2>Perfil de {{ $usuario->username }}</h2>

        <div class="card mb-3">
            <div class="card-body">
                <p><strong>Nombre:</strong> {{ $usuario->nombre }}</p>
                <p><strong>Email:</strong> {{ $usuario->email }}</p>
                <p><strong>Registrado el:</strong> {{ $usuario->created_at->format('d/m/Y') }}</p>
                <p><strong>Seguidores:</strong> <span id="seguidoresCount">{{ $usuario->contarSeguidores() }}</span></p>

                <button id="followButton" class="btn btn-primary" data-username="{{ $usuario->username }}">
                    Seguir
                </button>
            </div>
        </div>
    </div>

    <div id="notification-container"></div>

    <div id="confirmationModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro que quieres dejar de seguir a este usuario?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmUnfollow">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="{{ asset('css/confirmar.css') }}">
    <script src="{{ asset('js/seguir/seguir.js') }}" defer></script>
@endsection