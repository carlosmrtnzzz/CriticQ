@extends('layouts.base')
@section('titulo', 'Mensajes')

@section('content')
    <div class="container">
        <h2>Mensajes Privados</h2>

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="contacts-list">
            @if($contactos->isEmpty())
                <div class="alert alert-info">
                    No tienes conversaciones con tus contactos. Recuerda que solo puedes chatear con usuarios que te siguen y
                    que tú sigues.
                </div>
            @else
                <ul class="list-group">
                    @foreach($contactos as $contacto)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <img src="{{ $contacto->avatar ? asset('storage/' . $contacto->avatar) : asset('extra/default-foto.jpg') }}"
                                    alt="Foto de perfil" class="rounded-circle me-3" width="50" height="50"
                                    style="object-fit: cover;">
                                <div>
                                    <h5 class="mb-1">{{ $contacto->nombre }}</h5>
                                    <p class="text-muted mb-0"><span>@</span>{{ $contacto->username }}</p>
                                </div>
                            </div>
                            <a href="{{ route('chat.conversation', $contacto->id) }}" class="btn btn-primary">
                                <i class="fas fa-comments"></i> Chatear
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
@endsection