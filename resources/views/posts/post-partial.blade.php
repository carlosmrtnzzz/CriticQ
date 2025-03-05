@foreach ($posts as $post)
    <div class="card mb-3 post-item">
        <div class="card-body">
            <h4>
                @if ($post->usuario->avatar)
                    <img src="{{ asset('storage/' . $post->usuario->avatar) }}" alt="Avatar de {{ $post->usuario->username }}"
                        class="img-fluid rounded-circle" style="width: 60px; height: 60px; object-fit: cover;">
                @else
                    <img src="{{ asset('extra/default-foto.jpg') }}" alt="Avatar por defecto" class="img-fluid rounded-circle"
                        style="width: 60px; height: 60px; object-fit: cover;">
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
                            <i class="bi bi-heart-fill"></i> <span class="likes-count">{{ $post->likes->count() }}</span>
                        @else
                            <i class="bi bi-heart"></i> <span class="likes-count">{{ $post->likes->count() }}</span>
                        @endif
                    </button>
                </form>
                <p class="mb-0 ml-3"><i class="bi bi-graph-up"></i> {{ $post->vistas }}</p>
            </div>
            <a href="{{ route('posts.show', $post->id) }}" class="btn btn-primary mt-2">Ver detalles</a>
        </div>
    </div>
@endforeach