<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('hotel_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('note'); // sur 10
            $table->text('commentaire')->nullable();
            $table->enum('statut', ['en_attente', 'approuve', 'rejete'])->default('en_attente');
            $table->timestamps();

            // un seul avis par client et par hôtel
            $table->unique(['client_id', 'hotel_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
