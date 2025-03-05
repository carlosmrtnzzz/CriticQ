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
        Schema::create('usuarios', function (Blueprint $tabla) {
            $tabla->id();
            $tabla->string('username')->unique();
            $tabla->string('nombre')->nullable();
            $tabla->string('apellido')->nullable();
            $tabla->string('email')->unique();
            $tabla->string('password');
            $tabla->text('biografia')->nullable();
            $tabla->string('avatar')->nullable();
            $tabla->enum('rol', ['admin', 'usuario'])->default('usuario');
            $tabla->enum('estado', ['activo', 'inactivo', 'suspendido'])->default('activo');
            $tabla->rememberToken();
            $tabla->timestamps();
        });
    }
};