<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commentaire_logements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('logement_id')->constrained('logements')->cascadeOnDelete();
            $table->text('commentaire')->nullable();
            $table->unsignedTinyInteger('note'); // sur 10
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commentaire_logements');
    }
};
