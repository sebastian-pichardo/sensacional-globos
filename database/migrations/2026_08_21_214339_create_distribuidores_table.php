<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('distribuidores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido_paterno');
            $table->string('apellido_materno');
            $table->text('clave');
            $table->string('empresa')->nullable();
            $table->string('rfc')->nullable();
            $table->string('telefono')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('calle')->nullable();
            $table->string('num_exterior')->nullable();
            $table->string('num_interior')->nullable();
            $table->string('colonia')->nullable();
            $table->string('estado_clave');
            $table->string('codigo_postal');
            $table->string('email')->unique();
            $table->decimal('latitude', 24, 10)->nullable();
            $table->decimal('longitude', 24, 10)->nullable();
            $table->enum('activo', ['si', 'no'])->default('si');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distribuidores');
    }
};
