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
        Schema::create('globos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('medida');
            $table->string('descripcion', 355)->nullable();
            $table->string('imagen', 355)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('globos');
    }
};
