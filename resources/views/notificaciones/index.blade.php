@extends('layouts.base')

@section('titulo', 'Notificaciones')

@section('content')
    <div class="container">
        <h1>Notificaciones</h1>

        @if ($notificaciones->isEmpty())
            <p>No tienes notificaciones.</p>
        @else
            <ul class="list-group">
                @foreach ($notificaciones as $notificacion)
                    <li class="list-group-item @if(!$notificacion->leido_en) list-group-item-warning @endif">
                        <div>
                            <a href="{{ $notificacion->url }}" class="text-decoration-none">
                                <strong>{{ $notificacion->mensaje }}</strong>
                            </a>
                            <br>
                            <small>Recibida: {{ $notificacion->created_at->diffForHumans() }}</small>
                        </div>
                        <div class="d-flex justify-content-end">
                            @if(is_null($notificacion->leido_en))
                                <form action="{{ route('notificaciones.marcarComoLeida', $notificacion) }}" method="POST" class="mr-2">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-primary">Marcar como leída</button>
                                </form>
                            @endif
                            <form action="{{ route('notificaciones.destruir', $notificacion) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
            <div class="mt-3">
                <form action="{{ route('notificaciones.marcarTodasComoLeidas') }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-secondary">Marcar todas como leídas</button>
                </form>
            </div>
        @endif
    </div>
@endsection