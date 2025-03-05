<?php

namespace Database\Seeders;

use App\Models\Usuario;
use App\Models\Post;
use App\Models\Like;
use Illuminate\Database\Seeder;

class LikeSeeder extends Seeder
{
    public function run(): void
    {
        $users = Usuario::all();
        $posts = Post::all();
        $userIds = $users->pluck('id')->toArray();

        foreach ($posts as $post) {
            // Crear entre 0 y 15 likes para cada post
            $likeCount = rand(0, 15);

            // Solo ejecutar si likeCount es mayor que 0
            if ($likeCount > 0) {
                $randomUserIds = array_rand(array_flip($userIds), min($likeCount, count($userIds)));

                if (!is_array($randomUserIds)) {
                    $randomUserIds = [$randomUserIds];
                }

                foreach ($randomUserIds as $userId) {
                    Like::create([
                        'usuario_id' => $userId,
                        'post_id' => $post->id,
                    ]);
                }
            }
        }
    }
}