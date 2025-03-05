<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Auth;

class AutenticacionController extends Controller
{
    public function verLogin()
    {
        return view('login');
    }

    public function verRegistro()
    {
        return view('registro');
    }

    public function registrarUsuario(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => [
                'required',
                'string',
                'max:20',
                'unique:usuarios',
                'regex:/^[a-zA-Z0-9_]{5,15}$/'
            ],
            'nombre' => [
                'required',
                'string',
                'max:20',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,50}$/'
            ],
            'apellido' => [
                'required',
                'string',
                'max:20',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,50}$/'
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:50',
                'unique:usuarios'
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
            ],
            'avatar' => [
                'nullable',
                'image',
                'max:5120'
            ]
        ], [
            'username.required' => 'El nombre de usuario es obligatorio',
            'username.unique' => 'El nombre de usuario ya está en uso',

            'nombre.required' => 'El nombre es obligatorio',

            'apellido.required' => 'El apellido es obligatorio',

            'email.required' => 'El correo electrónico es obligatorio',
            'email.unique' => 'El correo electrónico ya está registrado',

            'password.required' => 'La contraseña es obligatoria',
            'password.confirmed' => 'Las contraseñas no coinciden',

            'avatar.image' => 'El archivo debe ser una imagen',
            'avatar.max' => 'El archivo debe tener un tamaño máximo de 5MB'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error_bag', $validator->errors());
        }

        $usuario = new Usuario();
        $usuario->username = $request->username;
        $usuario->nombre = $request->nombre;
        $usuario->apellido = $request->apellido;
        $usuario->email = $request->email;
        $usuario->password = Hash::make($request->password);
        $usuario->estado = 'activo';
        $usuario->avatar = $request->file('avatar')
            ? $request->file('avatar')->store('avatars', 'public')
            : null;
        $usuario->save();

        Auth::login($usuario);

        return redirect()->route('inicio')->with('success', 'Registro exitoso, bienvenido!');
    }

    public function iniciarSesion(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:usuarios,email',
            'password' => 'required|string|min:6',
        ]);

        $usuario = Usuario::where('email', $request->email)->first();

        if (!$usuario || !Hash::check($request->password, $usuario->password)) {
            return redirect()->back()
                ->withErrors(['error' => 'Las credenciales no son correctas'])
                ->withInput();
        }

        Auth::login($usuario);

        return redirect()->route('inicio')->with('success', 'Inicio de sesión exitoso');
    }
}