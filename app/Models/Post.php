<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'usuario_id',
        'contenido',
        'imagen',
        'es_publico',
        'vistas',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'es_publico' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the user that owns the post.
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    /**
     * Get the comments for the post.
     */
    public function comentarios()
    {
        return $this->hasMany(Comment::class, 'post_id');
    }

    /**
     * Get the likes for the post.
     */
    public function likes()
    {
        return $this->hasMany(Like::class, 'post_id');
    }

    /**
     * Check if the post is liked by a specific user.
     */
    public function isLikedByUser($user_id)
    {
        return $this->likes()->where('usuario_id', $user_id)->exists();
    }

    /**
     * Check if the post has been viewed by a specific user.
     */
    public function hasBeenViewedByUser($user_id)
    {
        return session()->has("post_{$this->id}_viewed_by_user_{$user_id}");
    }

    /**
     * Mark the post as viewed by a specific user.
     */
    public function markAsViewedByUser($user_id)
    {
        session()->put("post_{$this->id}_viewed_by_user_{$user_id}", true);
    }

    public function comments()
    {
        return $this->hasMany(\App\Models\Comment::class, 'post_id');
    }
}
