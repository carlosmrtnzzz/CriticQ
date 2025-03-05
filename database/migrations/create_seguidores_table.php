<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('seguidores', function (Blueprint $tabla) {
            $tabla->id();
            $tabla->foreignId('seguidor_id')->constrained('usuarios')->onDelete('cascade');
            $tabla->foreignId('seguido_id')->constrained('usuarios')->onDelete('cascade');
            $tabla->unique(['seguidor_id', 'seguido_id']);
            $tabla->enum('estado', ['pendiente', 'aceptado', 'rechazado'])->default('aceptado');
            $tabla->timestamps();
        });
    }
};