<?php
namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $seguidoresMutuos = DB::table('seguidores as s1')
            ->join('seguidores as s2', function ($join) {
                $join->on('s1.seguidor_id', '=', 's2.seguido_id')
                    ->on('s1.seguido_id', '=', 's2.seguidor_id');
            })
            ->where('s1.seguidor_id', $userId)
            ->where('s1.estado', 'aceptado')
            ->where('s2.estado', 'aceptado')
            ->join('usuarios', 'usuarios.id', '=', 's1.seguido_id')
            ->select('usuarios.*')
            ->distinct()
            ->get();

        $contactos = $seguidoresMutuos;

        return view('chat.index', compact('contactos'));
    }

    public function show($contactId)
    {
        $userId = Auth::id();
        $contacto = Usuario::findOrFail($contactId);

        $esSeguimientoMutuo = DB::table('seguidores as s1')
            ->join('seguidores as s2', function ($join) {
                $join->on('s1.seguidor_id', '=', 's2.seguido_id')
                    ->on('s1.seguido_id', '=', 's2.seguidor_id');
            })
            ->where('s1.seguidor_id', $userId)
            ->where('s1.seguido_id', $contactId)
            ->where('s1.estado', 'aceptado')
            ->where('s2.estado', 'aceptado')
            ->exists();

        if (!$esSeguimientoMutuo) {
            return redirect()->route('chat')->with('error', 'No puedes enviar mensajes a este usuario');
        }

        $mensajes = Message::where(function ($query) use ($userId, $contactId) {
            $query->where('emisor_id', $userId)->where('receptor_id', $contactId);
        })
            ->orWhere(function ($query) use ($userId, $contactId) {
                $query->where('emisor_id', $contactId)->where('receptor_id', $userId);
            })
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'asc')
            ->get();

        Message::where('emisor_id', $contactId)
            ->where('receptor_id', $userId)
            ->whereNull('leido_en')
            ->update(['leido_en' => now()]);

        return view('chat.conversation', compact('contacto', 'mensajes'));
    }

    public function getMessages(Request $request)
    {
        $userId = Auth::id();
        $contactId = $request->input('contact_id');
        $lastMessageId = $request->input('last_message_id', 0);

        $esSeguimientoMutuo = DB::table('seguidores as s1')
            ->join('seguidores as s2', function ($join) {
                $join->on('s1.seguidor_id', '=', 's2.seguido_id')
                    ->on('s1.seguido_id', '=', 's2.seguidor_id');
            })
            ->where('s1.seguidor_id', $userId)
            ->where('s1.seguido_id', $contactId)
            ->where('s1.estado', 'aceptado')
            ->where('s2.estado', 'aceptado')
            ->exists();

        if (!$esSeguimientoMutuo) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $mensajes = Message::where(function ($query) use ($userId, $contactId) {
            $query->where('emisor_id', $userId)->where('receptor_id', $contactId);
        })
            ->orWhere(function ($query) use ($userId, $contactId) {
                $query->where('emisor_id', $contactId)->where('receptor_id', $userId);
            })
            ->where('id', '>', $lastMessageId)
            ->with(['sender', 'receiver'])
            ->orderBy('id', 'asc')
            ->get();

        Message::where('emisor_id', $contactId)
            ->where('receptor_id', $userId)
            ->whereNull('leido_en')
            ->update(['leido_en' => now()]);

        return response()->json($mensajes);
    }

    public function store(Request $request)
    {
        $userId = Auth::id();
        $receptorId = $request->input('receptor_id');

        $esSeguimientoMutuo = DB::table('seguidores as s1')
            ->join('seguidores as s2', function ($join) {
                $join->on('s1.seguidor_id', '=', 's2.seguido_id')
                    ->on('s1.seguido_id', '=', 's2.seguidor_id');
            })
            ->where('s1.seguidor_id', $userId)
            ->where('s1.seguido_id', $receptorId)
            ->where('s1.estado', 'aceptado')
            ->where('s2.estado', 'aceptado')
            ->exists();

        if (!$esSeguimientoMutuo) {
            return response()->json(['error' => 'No puedes enviar mensajes a este usuario'], 403);
        }

        $message = Message::create([
            'emisor_id' => $userId,
            'receptor_id' => $receptorId,
            'contenido' => $request->input('contenido'),
        ]);

        return response()->json($message);
    }

    public function getUnreadCount()
    {
        $userId = Auth::id();
        $count = Message::where('receptor_id', $userId)
            ->whereNull('leido_en')
            ->count();

        return response()->json(['count' => $count]);
    }
}