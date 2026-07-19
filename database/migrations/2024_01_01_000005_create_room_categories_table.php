<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('room_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained()->cascadeOnDelete();
            $table->string('nom'); // ex: Suite, Chambre standard...
            $table->unsignedTinyInteger('capacite_adultes')->default(1);
            $table->unsignedTinyInteger('capacite_enfants')->default(0);
            $table->decimal('prix_nuit', 10, 2);
            $table->unsignedInteger('quantite_disponible')->default(1);
            $table->text('description')->nullable();
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('room_categories');
    }
};
