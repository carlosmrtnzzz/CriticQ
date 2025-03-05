<?php

namespace Database\Seeders;

use App\Models\Usuario;
use App\Models\Post;
use Illuminate\Database\Seeder;
class PostSeeder extends Seeder
{
    public function run(): void
    {
        $users = Usuario::all();

        foreach ($users as $user) {
            // Crear entre 1 y 5 posts para cada usuario
            $postCount = rand(1, 5);

            for ($i = 1; $i <= $postCount; $i++) {
                Post::create([
                    'usuario_id' => $user->id,
                    'contenido' => 'Este es el contenido del post ' . $i . ' del usuario ' . $user->username,
                    'imagen' => rand(0, 1) ? 'posts/img_' . $user->id . '_' . $i . '.jpg' : null,
                    'es_publico' => rand(0, 10) > 2, // 80% probabilidad de ser público
                    'video' => rand(0, 4) === 0 ? 'videos/video_' . $user->id . '_' . $i . '.mp4' : null, // 20% probabilidad de tener video
                ]);
            }
        }
    }
}