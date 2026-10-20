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
        Schema::create('globo_tiene_colores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('globo_id');
            $table->foreign('globo_id')
                ->references('id')
                ->on('globos')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('color_id');
            $table->foreign('color_id')
                ->references('id')
                ->on('colores')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('globo_imagen', 355)->nullable();
            $table->string('color')->nullable();
            $table->string('color_imagen', 355)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('globo_tiene_colores');
    }
};
