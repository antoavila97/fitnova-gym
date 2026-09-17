<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rutinas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entrenador_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('socio_id')->constrained('users')->cascadeOnDelete();
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->date('fecha_asignacion')->default(now()->toDateString());
            $table->enum('estado', ['activa', 'finalizada'])->default('activa');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rutinas');
    }
};