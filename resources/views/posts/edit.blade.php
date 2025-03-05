@extends('layouts.base')

@section('titulo', content: 'Editar post')

@section('content')
    <div class="container">
        <h2 class="mb-4">Editar Post</h2>

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="contenido" class="form-label">Contenido</label>
                <textarea class="form-control" name="contenido" required>{{ old('contenido', $post->contenido) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen</label>
                <input type="file" class="form-control" name="imagen">
            </div>

            <div class="mb-3">
                <label for="es_publico" class="form-label">¿Es público?</label>
                <select class="form-control" name="es_publico">
                    <option value="1" {{ $post->es_publico ? 'selected' : '' }}>Sí</option>
                    <option value="0" {{ !$post->es_publico ? 'selected' : '' }}>No</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Actualizar Post</button>
            <a href="{{ route('inicio') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection