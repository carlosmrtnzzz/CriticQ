<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutenticacionController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\PerfilController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\BuscadorController;
use App\Http\Controllers\NotificadorController;
use App\Http\Controllers\ProxyController;
use App\Http\Controllers\SeguidorController;

//Bienvenida

Route::get('/', [InicioController::class, 'verWelcome'])->name('welcome');

Route::get('/inicio', function () {
    return redirect()->route('posts.index');
})->name('inicio');

//Login y registro

Route::get('/login', [AutenticacionController::class, 'verLogin'])->name('login');
Route::post('/login', [AutenticacionController::class, 'iniciarSesion'])->name('login.post');

Route::get('/registro', [AutenticacionController::class, 'verRegistro'])->name('registro');
Route::post('/registro', [AutenticacionController::class, 'registrarUsuario'])->name('register.post');

Route::get('/usuario/{username}', [PerfilController::class, 'mostrar'])->name('usuario.mostrar');

Route::get('/buscar', [BuscadorController::class, 'buscar'])->name('buscar');

Route::middleware(['auth'])->group(function () {

    //Perfil de usuario

    Route::get('/perfil/{username}', [PerfilController::class, 'mostrarPerfil'])
        ->middleware('auth')
        ->name('perfil');

    Route::put('/perfil/{id}', [PerfilController::class, 'actualizar'])
        ->middleware('auth')
        ->name('perfil.actualizar');

    Route::post('/logout', function () {
        Auth::logout();
        return redirect()->route('login');
    })->name('logout');

    //Mensajes privados

    Route::get('/messages', [MessageController::class, 'index'])->name('chat');
    Route::get('/messages/{contactId}', [MessageController::class, 'show'])->name('chat.conversation');
    Route::get('/api/messages', [MessageController::class, 'getMessages'])->name('chat.getMessages');
    Route::post('/api/messages', [MessageController::class, 'store'])->name('chat.store');
    Route::get('/api/messages/unread', [MessageController::class, 'getUnreadCount'])->name('chat.unread');

    //Publicaciones

    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');
    Route::post('/posts/{id}/like', [PostController::class, 'like'])->name('posts.like');
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{id}', [PostController::class, 'update'])->name('posts.update');

    //Comentarios

    Route::post('/posts/{id}/comments', [PostController::class, 'storeComment'])->name('posts.comments.store');
    Route::delete('/comments/{id}', [PostController::class, 'deleteComment'])->name('posts.comments.destroy');

    //Notificaciones

    Route::get('/notificaciones', [NotificadorController::class, 'index'])->name('notificaciones.index');
    Route::patch('/notificaciones/{notification}/marcar-como-leida', [NotificadorController::class, 'marcarComoLeida'])->name('notificaciones.marcarComoLeida');
    Route::patch('/notificaciones/marcar-todas-como-leidas', [NotificadorController::class, 'marcarTodasComoLeidas'])->name('notificaciones.marcarTodasComoLeidas');
    Route::delete('/notificaciones/{notification}', [NotificadorController::class, 'destruir'])->name('notificaciones.destruir');

    // Ruta para ver el perfil de un usuario

    Route::get('usuario/{username}', [PerfilController::class, 'mostrar'])->name('usuario');

    // Ruta para peticiones de la API    
    Route::get('/proxy/giveaways', [ProxyController::class, 'getGiveaways']);

    // Ruta para seguir a un usuario
    Route::post('/seguir', [SeguidorController::class, 'seguir'])->middleware('auth');
    Route::get('/verificar-seguimiento/{username}', [SeguidorController::class, 'verificarSeguimiento'])->middleware('auth');

});