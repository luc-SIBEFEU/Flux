<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('amenities', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->unique(); // wifi, piscine, climatisation, parking...
            $table->string('icone')->nullable(); // nom d'icône (heroicon) pour l'affichage
            $table->timestamps();
        });

        Schema::create('amenity_room_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('amenity_id')->constrained()->cascadeOnDelete();
            $table->unique(['room_category_id', 'amenity_id'], 'amenity_room_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('amenity_room_category');
        Schema::dropIfExists('amenities');
    }
};
