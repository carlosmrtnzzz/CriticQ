<?php

namespace Database\Seeders;

use App\Models\Usuario;
use App\Models\Message;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    public function run(): void
    {
        $users = Usuario::all();
        $userCount = count($users);

        // Crear conversaciones entre usuarios aleatorios
        for ($i = 0; $i < 20; $i++) {
            $senderIndex = rand(0, $userCount - 1);
            $receiverIndex = rand(0, $userCount - 1);
            
            // Evitar que un usuario se envíe mensajes a sí mismo
            while ($senderIndex == $receiverIndex) {
                $receiverIndex = rand(0, $userCount - 1);
            }
            
            $sender = $users[$senderIndex];
            $receiver = $users[$receiverIndex];
            
            // Crear entre 1 y 5 mensajes en esta conversación
            $messageCount = rand(1, 5);
            
            for ($j = 1; $j <= $messageCount; $j++) {
                Message::create([
                    'emisor_id' => $sender->id,
                    'receptor_id' => $receiver->id,
                    'contenido' => 'Hola! Este es el mensaje ' . $j . ' de la conversación.',
                    'leido_en' => rand(0, 1) ? now() : null,
                ]);
                
                // Ocasionalmente añadir una respuesta
                if (rand(0, 1) == 1) {
                    Message::create([
                        'emisor_id' => $receiver->id,
                        'receptor_id' => $sender->id,
                        'contenido' => 'Gracias por tu mensaje. Te respondo!',
                        'leido_en' => rand(0, 1) ? now() : null,
                    ]);
                }
            }
        }
    }
}