<?php

namespace App\Http\Controllers;

use App\Models\Follower;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeguidorController extends Controller
{
    public function seguir(Request $request)
    {
        $usuarioSeguido = Usuario::where('username', $request->username)->firstOrFail();
        $usuarioActual = Auth::user();

        $seguimiento = Follower::where('seguidor_id', $usuarioActual->id)
            ->where('seguido_id', $usuarioSeguido->id)
            ->first();

        if ($seguimiento) {
            $seguimiento->delete();
            $estado = false;
        } else {
            Follower::create([
                'seguidor_id' => $usuarioActual->id,
                'seguido_id' => $usuarioSeguido->id,
                'estado' => 'aceptado'
            ]);
            $estado = true;
        }

        $seguidoresCount = $usuarioSeguido->contarSeguidores();

        return response()->json([
            'following' => $estado,
            'seguidores' => $seguidoresCount
        ]);
    }

    public function verificarSeguimiento($username)
    {
        $usuarioSeguido = Usuario::where('username', $username)->firstOrFail();
        $usuarioActual = Auth::user();

        $siguiendo = Follower::where('seguidor_id', $usuarioActual->id)
            ->where('seguido_id', $usuarioSeguido->id)
            ->exists();

        return response()->json(['following' => $siguiendo]);
    }
}