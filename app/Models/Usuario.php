<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'nombre',
        'apellido',
        'email',
        'password',
        'biografia',
        'avatar',
        'rol',
        'estado',
        'remember_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the posts for the user.
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'usuario_id');
    }

    /**
     * Get the comments for the user.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'usuario_id');
    }

    /**
     * Get the likes for the user.
     */
    public function likes()
    {
        return $this->hasMany(Like::class, 'usuario_id');
    }

    /**
     * Get the notifications for the user.
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'usuario_id');
    }

    /**
     * Get the followers of the user.
     */
    public function followers()
    {
        return $this->hasMany(Follower::class, 'seguido_id');
    }

    /**
     * Get the users that the user follows.
     */
    public function following()
    {
        return $this->hasMany(Follower::class, 'seguidor_id');
    }

    /**
 * Contar el número de seguidores del usuario.
 */
    public function contarSeguidores()
    {
        return $this->followers()->count();
    }

/**
 * Contar el número de usuarios que el usuario sigue.
 */
    public function contarSiguiendo()
    {
        return $this->following()->count();
    }
}