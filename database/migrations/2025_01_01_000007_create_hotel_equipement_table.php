<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hotel_equipements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained('hotels')->cascadeOnDelete();
            $table->foreignId('equipement_id')->constrained('equipements')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['hotel_id', 'equipement_id'], 'cat_hotel_equip_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hotel_equipements');
    }
};
