<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notificaciones';

  
    protected $fillable = [
        'usuario_id',
        'tipo',
        'usuario_accion_id',
        'notificable_id',
        'notificable_type',
        'mensaje',
        'leido_en',
    ];


    protected $casts = [
        'leido_en' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


    public function user()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }


    public function notificable()
    {
        return $this->morphTo();
    }


    public function scopeUnread($query)
    {
        return $query->whereNull('leido_en');
    }

    public function getUrlAttribute()
    {
        // Notificación de "like"
        if ($this->tipo == 'like' && $this->notificable_type == 'App\\Models\\Post') {
            return route('posts.show', $this->notificable_id); 
        }

        // Notificación de "comentario"
        if ($this->tipo == 'comment' && $this->notificable_type == 'App\\Models\\Comment') {
            return route('posts.show', $this->notificable_id); 
        }

        // Notificación de "seguimiento"
        if ($this->tipo == 'follow' && $this->notificable_type == 'App\\Models\\Usuario') {
            return route('usuario', ['username' => $this->notificable->username]); 
        }


        return '#';
    }




}