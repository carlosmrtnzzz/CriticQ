<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mensajes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'emisor_id',
        'receptor_id',
        'contenido',
        'leido_en',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'leido_en' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the user who sent the message.
     */
    public function sender()
    {
        return $this->belongsTo(Usuario::class, 'emisor_id');
    }

    /**
     * Get the user who received the message.
     */
    public function receiver()
    {
        return $this->belongsTo(Usuario::class, 'receptor_id');
    }
}