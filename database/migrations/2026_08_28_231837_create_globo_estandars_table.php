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
        Schema::create('globos_estandar', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('color')->nullable();
            $table->string('ruta_img')->nullable();
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
        Schema::dropIfExists('globos_estandar');
    }
};
