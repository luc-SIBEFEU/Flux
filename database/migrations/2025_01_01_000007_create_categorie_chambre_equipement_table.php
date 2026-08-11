<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categorie_chambre_equipement', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categorie_chambre_id')->constrained('categorie_chambres')->cascadeOnDelete();
            $table->foreignId('equipement_id')->constrained('equipements')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['categorie_chambre_id', 'equipement_id'], 'cat_chambre_equip_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categorie_chambre_equipement');
    }
};
