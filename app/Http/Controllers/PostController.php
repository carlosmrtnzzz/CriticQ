<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;
use App\Http\Controllers\NotificadorController;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::with('usuario')
            ->orderBy('created_at', 'desc')
            ->paginate(4);

        if ($request->input('ajax') || $request->ajax()) {
            $html = view('posts.post-partial', ['posts' => $posts])->render();
            return response()->json([
                'html' => $html,
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'total_posts' => $posts->total()
            ]);
        }

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'contenido' => 'required|string',
            'imagen' => 'nullable|image|max:2048',
            'es_publico' => 'required|boolean',
        ]);

        $validatedData['usuario_id'] = auth()->id();
        $validatedData['vistas'] = 0;

        if ($request->hasFile('imagen')) {
            $validatedData['imagen'] = $request->file('imagen')->store('posts', 'public');
        }

        Post::create($validatedData);

        return redirect()->route('inicio')->with('success', 'Post creado exitosamente.');
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        $user_id = Auth::id();
        $comments = $post->comments()->with('user')->orderBy('created_at', 'desc')->get();


        $vista_key = "post_visto_{$post->id}_user_{$user_id}";
        if (!session()->has($vista_key)) {
            $post->increment('vistas');
            session()->put($vista_key, true);
        }

        return view('posts.show', compact('post', 'comments'));
    }


    public function storeComment(Request $request, $postId)
    {
        $request->validate([
            'contenido' => 'required|string|max:500',
            'comentario_padre_id' => 'nullable|exists:comentarios,id'
        ]);

        $comment = new Comment();
        $comment->contenido = $request->contenido;
        $comment->usuario_id = Auth::id();
        $comment->post_id = $postId;
        $comment->comentario_padre_id = $request->comentario_padre_id;
        $comment->save();

        $post = Post::findOrFail($postId);

        if ($post->usuario_id !== Auth::id()) {
            $notificador = new NotificadorController();
            $notificador->crearNotificacion(
                $post->usuario_id,
                'comment',
                Auth::id(),
                $post->id,
                'App\Models\Comment',
                Auth::user()->username . ' comentó en tu publicación.'
            );
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'comment' => [
                    'id' => $comment->id,
                    'contenido' => $comment->contenido,
                    'created_at' => $comment->created_at->diffForHumans(),
                    'usuario' => [
                        'username' => Auth::user()->username,
                        'avatar' => Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('storage/default-avatar.png')
                    ]
                ]
            ]);
        }

        return redirect()->back()->with('success', 'Comentario añadido correctamente.');
    }


    public function deleteComment($commentId)
    {
        $comment = Comment::findOrFail($commentId);

        if ($comment->usuario_id !== Auth::id()) {
            return redirect()->back()->with('error', 'No tienes permiso para eliminar este comentario.');
        }

        $comment->delete();

        return redirect()->back()->with('success', 'Comentario eliminado correctamente.');
    }
    public function like(Request $request, $id)
    {
        if ($request->ajax()) {
            $post = Post::findOrFail($id);
            $user_id = Auth::id();
            $like = Like::where('post_id', $post->id)->where('usuario_id', $user_id)->first();

            if ($like) {
                $like->delete();
                return response()->json([
                    'status' => 'unliked',
                    'likes_count' => $post->likes->count(),
                    'vistas' => $post->vistas
                ]);
            } else {
                $like = new Like();
                $like->usuario_id = $user_id;
                $like->post_id = $post->id;
                $like->save();

                $vista_key = "post_visto_{$post->id}_user_{$user_id}";
                if (!session()->has($vista_key)) {
                    $post->increment('vistas');
                    session()->put($vista_key, true);
                }

                if ($post->usuario_id !== $user_id) {
                    $notificador = new NotificadorController();
                    $notificador->crearNotificacion(
                        $post->usuario_id,
                        'like',
                        $user_id,
                        $post->id,
                        'App\Models\Post',
                        'A ' . Auth::user()->username . ' le gustó tu publicación.'
                    );
                }

                return response()->json([
                    'status' => 'liked',
                    'likes_count' => $post->likes->count(),
                    'vistas' => $post->vistas
                ]);
            }
        }
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);

        if ($post->usuario_id !== Auth::id()) {
            return redirect()->route('inicio')->with('error', 'No tienes permiso para editar este post.');
        }

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        if ($post->usuario_id !== Auth::id()) {
            return redirect()->route('inicio')->with('error', 'No tienes permiso para editar este post.');
        }

        $validatedData = $request->validate([
            'contenido' => 'required|string',
            'imagen' => 'nullable|image|max:2048',
            'es_publico' => 'required|boolean',
        ]);

        if ($request->hasFile('imagen')) {
            $validatedData['imagen'] = $request->file('imagen')->store('posts', 'public');
        }

        $post->update($validatedData);

        return redirect()->route('inicio')->with('success', 'Post actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if ($post->usuario_id !== Auth::id()) {
            return redirect()->route('inicio')->with('error', 'No tienes permiso para eliminar este post.');
        }

        $post->delete();

        return redirect()->route('inicio')->with('success', 'Post eliminado exitosamente.');
    }
}