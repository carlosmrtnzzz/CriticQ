<?php

namespace Database\Seeders;

use App\Models\Usuario;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Notification;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        $users = Usuario::all();
        $posts = Post::all();
        $comments = Comment::all();

        $notificationTypes = ['like', 'comment', 'follow'];

        foreach ($users as $user) {
            // Crear entre 1 y 5 notificaciones para cada usuario
            $notificationCount = rand(1, 5);

            for ($i = 0; $i < $notificationCount; $i++) {
                $type = $notificationTypes[array_rand($notificationTypes)];
                $accionId = null;
                $notificableId = null;
                $notificableType = null;
                $mensaje = '';

                switch ($type) {
                    case 'like':
                        if ($posts->isEmpty()) continue 2; // Salta al siguiente usuario si no hay posts
                        $randomPost = $posts->random();
                        $notificableId = $randomPost->id;
                        $notificableType = Post::class;
                        $randomUser = $users->where('id', '!=', $user->id)->random();
                        $accionId = $randomUser->id;
                        $mensaje = "A alguien le gustó tu publicación.";
                        break;

                    case 'comment':
                        if ($comments->isEmpty()) continue 2; // Salta al siguiente usuario si no hay comentarios
                        $randomComment = $comments->random();
                        $notificableId = $randomComment->id;
                        $notificableType = Comment::class;
                        $randomUser = $users->where('id', '!=', $user->id)->random();
                        $accionId = $randomUser->id;
                        $mensaje = "Alguien comentó en tu publicación.";
                        break;

                    case 'follow':
                        $randomUser = $users->where('id', '!=', $user->id)->random();
                        $accionId = $randomUser->id;
                        $notificableId = $randomUser->id;
                        $notificableType = Usuario::class;
                        $mensaje = "Tienes un nuevo seguidor.";
                        break;
                }

                Notification::create([
                    'usuario_id' => $user->id,
                    'tipo' => $type,
                    'usuario_accion_id' => $accionId,
                    'notificable_id' => $notificableId,
                    'notificable_type' => $notificableType,
                    'mensaje' => $mensaje,
                    'leido_en' => rand(0, 1) ? now() : null,
                ]);
            }
        }
    }
}
