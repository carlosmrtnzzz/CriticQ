@extends('layouts.base')

@section('titulo', 'Explorar')

@section('content')
    <div class="container mt-5">
        <h2>Buscador</h2>

        <div class="input-group mb-4">
            <input type="text" id="searchInput" class="form-control" placeholder="Buscar usuarios...">
        </div>

        <ul id="resultList" class="list-group"></ul>
    </div>

    <div class="container mt-4 noticias">
        <h2 class="text-center mb-4">Últimas Noticias de Videojuegos</h2>
        <div id="newsContainer" class="row row-cols-1 row-cols-md-3 g-4">

        </div>
    </div>

    <script src="{{ asset('js/extra/buscador.js') }}"></script>
    <script src="{{ asset('js/APIS/noticiasAPI.js') }}"></script>

@endsection