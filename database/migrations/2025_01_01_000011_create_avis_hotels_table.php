<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('avis_hotels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('hotel_id')->constrained('hotels')->cascadeOnDelete();
            $table->text('commentaire')->nullable();
            $table->unsignedTinyInteger('note'); // sur 10
            $table->enum('statut', ['en_attente', 'approuve', 'rejete'])->default('en_attente');
            $table->timestamps();

            // un client ne note qu'une fois le meme hotel
            $table->unique(['client_id', 'hotel_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('avis_hotels');
    }
};
