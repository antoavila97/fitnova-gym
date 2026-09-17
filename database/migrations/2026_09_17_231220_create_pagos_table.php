<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membresia_id')->constrained('membresias')->cascadeOnDelete();
            $table->foreignId('socio_id')->constrained('users')->cascadeOnDelete();
            $table->decimal('monto', 10, 2);
            $table->date('fecha_pago');
            $table->enum('metodo', ['efectivo', 'tarjeta', 'transferencia'])->default('efectivo');
            $table->string('concepto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};