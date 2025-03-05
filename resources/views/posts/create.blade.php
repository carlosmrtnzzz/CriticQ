@extends('layouts.base')

@section('titulo', 'Crear post')

@section('content')
    <div class="container">
        <h1>Crear Post</h1>
        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="contenido">Contenido</label>
                <textarea name="contenido" id="contenido" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="imagen">Imagen (opcional)</label>
                <input type="file" name="imagen" id="imagen" class="form-control">
            </div>
            <div class="form-group">
                <label for="es_publico">¿Es público?</label>
                <select name="es_publico" id="es_publico" class="form-control" required>
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Publicar</button>
        </form>
    </div>
@endsection