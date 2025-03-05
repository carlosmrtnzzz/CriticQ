@extends('layouts.base')

@section('titulo', 'Detalles del Post')

@section('content')
    <div class="container">
        <h1>Detalles del Post</h1>
        <a href="{{ route('inicio') }}" class="btn btn-secondary mt-2">Salir</a>
        <div class="card mb-3">
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
                <div class="d-flex align-items-center mt-3">
                    <form action="{{ route('posts.like', $post->id) }}" method="POST" class="like-form ml-2">
                        @csrf
                        <button type="submit" class="btn btn-sm ml-2 like-button">
                            @if ($post->isLikedByUser(Auth::id()))
                                <i class="bi bi-heart-fill"></i> <span class="likes-count">{{ $post->likes->count() }}</span>
                            @else
                                <i class="bi bi-heart"></i> <span class="likes-count">{{ $post->likes->count() }}</span>
                            @endif
                        </button>
                    </form>
                    <p class="mb-0 ml-3"><i class="bi bi-graph-up"></i> {{ $post->vistas }}</p>
                    @if ($post->usuario_id === Auth::id())
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="ml-3 delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm"><i class="bi bi-trash"></i></button>
                        </form>
                    @endif
                </div>

                @if ($post->usuario_id === Auth::id())
                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-secondary mt-2">Editar</a>
                @endif

            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h4>Comentarios ({{ $comments->count() }})</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('posts.comments.store', $post->id) }}" method="POST" class="mb-4" id="comment-form">
                    @csrf
                    <div class="form-group">
                        <textarea name="contenido" class="form-control" placeholder="Escribe un comentario..."
                            required></textarea>
                    </div>
                    <input type="hidden" name="comentario_padre_id" id="comentario_padre_id" value="">
                    <div class="d-flex justify-content-between align-items-center">
                        <button type="submit" class="btn btn-primary">Comentar</button>
                        <div id="replying-to" class="text-muted" style="display: none;">
                            Respondiendo a: <span id="parent-username"></span>
                            <button type="button" class="btn btn-sm btn-link" id="cancel-reply">Cancelar</button>
                        </div>
                    </div>
                </form>

                <div id="comments-container">
                    @foreach($comments as $comment)
                        @if(is_null($comment->comentario_padre_id))
                            <div class="comment-card mb-3" id="comment-{{ $comment->id }}">
                                <div class="d-flex">
                                    @if ($comment->user->avatar)
                                        <img src="{{ asset('storage/' . $comment->user->avatar) }}" alt="Avatar"
                                            class="img-fluid rounded-circle mr-3" style="width: 40px; height: 40px; object-fit: cover;">
                                    @else
                                        <img src="{{ asset('extra/default-foto.jpg') }}" alt="Avatar"
                                            class="img-fluid rounded-circle mr-3" style="width: 40px; height: 40px; object-fit: cover;">
                                    @endif
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between">
                                            <h5 class="mb-0">{{ $comment->user->username }} <small
                                                    class="text-muted">{{ $comment->created_at->diffForHumans() }}</small></h5>
                                            <div>
                                                <button class="btn btn-sm btn-link reply-btn" data-comment-id="{{ $comment->id }}"
                                                    data-username="{{ $comment->user->username }}">Responder</button>
                                                @if($comment->usuario_id === Auth::id())
                                                    <form action="{{ route('posts.comments.destroy', $comment->id) }}" method="POST"
                                                        class="d-inline delete-comment-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-link text-danger">Eliminar</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                        <p class="mt-2">{{ $comment->contenido }}</p>

                                        <div class="replies ml-4">
                                            @foreach($comments as $reply)
                                                @if($reply->comentario_padre_id == $comment->id)
                                                    <div class="reply-card mt-2 mb-2" id="comment-{{ $reply->id }}">
                                                        <div class="d-flex">
                                                            @if ($reply->user->avatar)
                                                                <img src="{{ asset('storage/' . $reply->user->avatar) }}" alt="Avatar"
                                                                    class="img-fluid rounded-circle mr-3"
                                                                    style="width: 30px; height: 30px; object-fit: cover;">
                                                            @else
                                                                <img src="{{ asset('extra/default-foto.jpg') }}" alt="Avatar"
                                                                    class="img-fluid rounded-circle mr-3"
                                                                    style="width: 30px; height: 30px; object-fit: cover;">
                                                            @endif
                                                            <div class="flex-grow-1">
                                                                <div class="d-flex justify-content-between">
                                                                    <h6 class="mb-0">{{ $reply->user->username }} <small
                                                                            class="text-muted">{{ $reply->created_at->diffForHumans() }}</small>
                                                                    </h6>
                                                                    <div>
                                                                        <button class="btn btn-sm btn-link reply-btn"
                                                                            data-comment-id="{{ $comment->id }}"
                                                                            data-username="{{ $reply->user->username }}">Responder</button>
                                                                        @if($reply->usuario_id === Auth::id())
                                                                            <form action="{{ route('posts.comments.destroy', $reply->id) }}"
                                                                                method="POST" class="d-inline delete-comment-form">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit"
                                                                                    class="btn btn-sm btn-link text-danger">Eliminar</button>
                                                                            </form>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <p class="mt-2">{{ $reply->contenido }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/publicaciones/publicacionesDetalles.js') }}"></script>

@endsection