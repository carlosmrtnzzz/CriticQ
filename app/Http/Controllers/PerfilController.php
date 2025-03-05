<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PerfilController extends Controller
{
    public function mostrarPerfil($username)
    {
        $usuario = Usuario::where('username', $username)->firstOrFail();

        if (Auth::user()->id !== $usuario->id) {
            abort(403, 'No tienes permiso para ver este perfil.');
        }

        return view('perfil', compact('usuario'));
    }
    public function mostrar($username)
    {
        $usuario = Usuario::where('username', $username)->firstOrFail();
        return view('usuario', compact('usuario'));
    }

    public function actualizar(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:usuarios,username,' . $id,
            'email' => 'required|email|max:255|unique:usuarios,email,' . $id,
            'biografia' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $usuario->update($request->only(['nombre', 'apellido', 'username', 'email', 'biografia']));

        if ($request->hasFile('avatar')) {
            if ($usuario->avatar) {
                Storage::disk('public')->delete($usuario->avatar);
            }

            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $usuario->avatar = $avatarPath;
            $usuario->save();
        }

        return redirect()->back()->with('success', 'Perfil actualizado correctamente.');
    }
}