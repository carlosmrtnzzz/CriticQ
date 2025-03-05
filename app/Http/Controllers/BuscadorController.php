<?php

namespace App\Http\Controllers;
use App\Models\Usuario;
use Illuminate\Http\Request;

class BuscadorController extends Controller
{
    public function buscar(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->input('query');
            $usuarios = Usuario::where('username', 'like', "%$query%")->get();
            return response()->json($usuarios);
        }
        return view('buscador.buscar');
    }
}