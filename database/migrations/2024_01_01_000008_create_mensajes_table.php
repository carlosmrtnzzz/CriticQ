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
        Schema::create('mensajes', function (Blueprint $tabla) {
            $tabla->id();
            $tabla->foreignId('emisor_id')->constrained('usuarios')->onDelete('cascade');
            $tabla->foreignId('receptor_id')->constrained('usuarios')->onDelete('cascade');
            $tabla->text('contenido');
            $tabla->timestamp('leido_en')->nullable();
            $tabla->timestamps();
            $tabla->softDeletes();
        });
    }

};
