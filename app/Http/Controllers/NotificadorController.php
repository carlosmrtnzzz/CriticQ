<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificadorController extends Controller
{

    public function crearNotificacion($usuarioId, $tipo, $usuarioAccionId, $notificableId, $notificableType, $mensaje)
    {
        return Notification::create([
            'usuario_id' => $usuarioId,
            'tipo' => $tipo,
            'usuario_accion_id' => $usuarioAccionId,
            'notificable_id' => $notificableId,
            'notificable_type' => $notificableType,
            'mensaje' => $mensaje,
            'leido_en' => null,
        ]);
    }


    public function index()
    {
        $notificaciones = Auth::user()->notifications()->latest()->get();
        return view('notificaciones.index', compact('notificaciones'));
    }


    public function marcarComoLeida(Notification $notification)
    {
        $notification->update(['leido_en' => now()]);
        return redirect()->route('notificaciones.index');
    }


    public function marcarTodasComoLeidas()
    {
        Auth::user()->notifications()->whereNull('leido_en')->update(['leido_en' => now()]);
        return redirect()->route('notificaciones.index');
    }

    public function destruir(Notification $notification)
    {
        $notification->delete();
        return redirect()->route('notificaciones.index');
    }
}
