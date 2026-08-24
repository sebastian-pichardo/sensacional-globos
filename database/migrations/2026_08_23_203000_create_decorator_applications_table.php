<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('decorator_applications', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120);
            $table->string('whatsapp', 30);
            $table->string('email');
            $table->text('motivation');
            $table->string('social_networks', 500)->nullable();
            $table->string('city_or_state', 120);
            $table->boolean('accept_promotions')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('decorator_applications');
    }
};
