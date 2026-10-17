<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diy_globo_selecciones', function (Blueprint $table) {
            $table->id();
            $table->json('seleccion');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diy_globo_selecciones');
    }
};
