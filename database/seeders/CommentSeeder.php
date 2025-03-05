<?php

namespace Database\Seeders;

use App\Models\Usuario;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $posts = Post::all();
        $users = Usuario::all();
        $userIds = $users->pluck('id')->toArray();

        foreach ($posts as $post) {
            // Crear entre 0 y 8 comentarios para cada post
            $commentCount = rand(0, 8);
            
            for ($i = 1; $i <= $commentCount; $i++) {
                $randomUserId = $userIds[array_rand($userIds)];
                
                Comment::create([
                    'usuario_id' => $randomUserId,
                    'post_id' => $post->id,
                    'contenido' => 'Este es un comentario ' . $i . ' en el post. ¡Muy interesante!',
                    'comentario_padre_id' => null, 
                ]);
            }
        }

        // Añadir algunos comentarios de respuesta
        $comments = Comment::all();
        foreach ($comments as $comment) {

            if (rand(1, 10) <= 3) {
                $randomUserId = $userIds[array_rand($userIds)];
                
                Comment::create([
                    'usuario_id' => $randomUserId,
                    'post_id' => $comment->post_id,
                    'contenido' => 'Esta es una respuesta al comentario anterior.',
                    'comentario_padre_id' => $comment->id,
                ]);
            }
        }
    }
}