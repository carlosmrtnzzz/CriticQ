@extends('layouts.base')

@section('titulo', 'Perfil')

@section('content')
    <div class="container perfilContenedor">

        <div class="text-center">
            <img src="{{ $usuario->avatar ? asset('storage/' . $usuario->avatar) : asset('extra/default-foto.jpg') }}"
                alt="Avatar de {{ $usuario->nombre }}" class="rounded-circle fotoDePerfil" width="250" height="250"
                style="object-fit: cover;">
        </div>

        <h1>Perfil de {{ ucfirst($usuario->nombre) }} {{ ucfirst($usuario->apellido) }}</h1>
        <p><strong>Nombre de usuario:</strong> {{ ucfirst($usuario->username) }}</p>
        <p><strong>Email:</strong> {{ $usuario->email }}</p>
        <p><strong>Biografía:</strong> {{ $usuario->biografia ?? 'Sin biografía' }}</p>

        <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#editProfileModal">
            Editar perfil
        </button>

        <h3 class="mt-4">Publicaciones Recientes</h3>
        @foreach($usuario->posts as $post)
            <div class="card mb-3">
                <div class="card-body">
                    <p><a href="{{ route('posts.show', $post->id) }}" class="text-decoration-none">{{ $post->contenido }}</a>
                    </p>
                    <small>Publicado el {{ $post->created_at }}</small>
                    <div class="mt-2">
                        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('¿Estás seguro de eliminar este post?')"><i
                                    class="bi bi-trash3"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Editar Perfil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('perfil.actualizar', $usuario->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control"
                                value="{{ ucfirst($usuario->nombre) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input type="text" name="apellido" id="apellido" class="form-control"
                                value="{{ ucfirst($usuario->apellido) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="username" class="form-label">Nombre de usuario</label>
                            <input type="text" name="username" id="username" class="form-control"
                                value="{{ $usuario->username }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ $usuario->email }}"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="biografia" class="form-label">Biografía</label>
                            <textarea name="biografia" id="biografia"
                                class="form-control">{{ $usuario->biografia }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="avatar" class="form-label">Cambiar Avatar (Máximo 2 MB)</label>
                            <input type="file" name="avatar" id="avatar" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-success">Guardar cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection