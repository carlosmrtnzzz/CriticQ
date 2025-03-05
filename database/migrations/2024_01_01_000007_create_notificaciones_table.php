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
        Schema::create('notificaciones', function (Blueprint $tabla) {
            $tabla->id();
            $tabla->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');
            $tabla->string('tipo');
            $tabla->foreignId('usuario_accion_id')->nullable()->constrained('usuarios')->onDelete('cascade');
            $tabla->morphs('notificable');
            $tabla->text('mensaje');
            $tabla->timestamp('leido_en')->nullable();
            $tabla->timestamps();
        });
    }
};
