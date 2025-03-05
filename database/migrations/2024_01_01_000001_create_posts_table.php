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
        Schema::create('posts', function (Blueprint $tabla) {
            $tabla->id();
            $tabla->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');
            $tabla->text('contenido');
            $tabla->string('imagen')->nullable();
            $tabla->string('video')->nullable();  
            $tabla->boolean('es_publico')->default(true);
            $tabla->integer('vistas')->default(0);
            $tabla->timestamps();
            $tabla->softDeletes();
        });
    }
};