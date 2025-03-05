@extends('layouts.base')

@section('titulo', 'Inicio')

@section('content')
    <div class="container">
        <h1>CriticQ</h1>
        <a href="{{ route('posts.create') }}" class="btn btn-success mb-3">Crear Nuevo Post</a>

        <div id="posts-container">
            @foreach ($posts as $index => $post)
                <div class="card mb-3 post-item">
                    <div class="card-body">
                        <h4>
                            @if ($post->usuario->avatar)
                                <img src="{{ asset('storage/' . $post->usuario->avatar) }}"
                                    alt="Avatar de {{ $post->usuario->username }}" class="img-fluid rounded-circle"
                                    style="width: 60px; height: 60px; object-fit: cover;">
                            @else
                                <img src="{{ asset('extra/default-foto.jpg') }}" alt="Avatar por defecto"
                                    class="img-fluid rounded-circle" style="width: 60px; height: 60px; object-fit: cover;">
                            @endif
                            {{ $post->usuario->username ?? 'Usuario desconocido' }} - {{ $post->created_at->diffForHumans() }}
                        </h4>
                        <p>{{ $post->contenido }}</p>
                        @if ($post->imagen)
                            <img src="{{ asset('storage/' . $post->imagen) }}" alt="Imagen del post" class="img-fluid">
                        @endif

                        <div class="d-flex align-items-center">
                            <form action="{{ route('posts.like', $post->id) }}" method="POST" class="like-form ml-2">
                                @csrf
                                <button type="submit" class="btn btn-sm ml-2 like-button">
                                    @if ($post->isLikedByUser(Auth::id()))
                                        <i class="bi bi-heart-fill"></i> <span
                                            class="likes-count">{{ $post->likes->count() }}</span>
                                    @else
                                        <i class="bi bi-heart"></i> <span class="likes-count">{{ $post->likes->count() }}</span>
                                    @endif
                                </button>
                            </form>
                            <span class="mb-0 ml-3 vistas-count"><i class="bi bi-graph-up"></i> {{ $post->vistas }}</span>
                        </div>
                        <a href="{{ route('posts.show', $post->id) }}" class="btn btn-primary mt-2">Ver detalles</a>
                    </div>
                </div>


                @if (($index + 1) % 5 === 0)
                    <div class="card mb-3 gift-card" id="gift-{{ $index + 1 }}">
                        <div class="card-body">
                            <h5 class="card-title">¡Regalo Especial!</h5>
                            <div id="gift-content-{{ $index + 1 }}"></div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <div id="loading" class="text-center d-none loadingContainer">
            <div class="spinner-border" role="status">
                <span class="sr-only">Cargando...</span>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/publicaciones/publicacionesAsincronas.js') }}"></script>
    <script src="{{ asset('js/APIS/regalosAPI.js') }}"></script>

@endsection