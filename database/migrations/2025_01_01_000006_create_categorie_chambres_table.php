<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categorie_chambres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained('hotels')->cascadeOnDelete();
            $table->string('nom'); // ex: Chambre standard, Suite
            $table->unsignedTinyInteger('capacite_adultes')->default(0);
            $table->unsignedTinyInteger('capacite_enfants')->default(0);
            $table->decimal('prix_nuit', 10, 2);
            $table->unsignedInteger('nombre_disponible')->default(1);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categorie_chambres');
    }
};
