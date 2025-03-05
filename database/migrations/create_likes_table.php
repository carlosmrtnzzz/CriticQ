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
        Schema::create('likes', function (Blueprint $tabla) {
            $tabla->id();
            $tabla->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');
            $tabla->foreignId('post_id')->constrained('posts')->onDelete('cascade');
            $tabla->unique(['usuario_id', 'post_id']);
            $tabla->timestamps();
        });
    }
};