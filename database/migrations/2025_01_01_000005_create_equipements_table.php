<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Liste partagee d'accessoires : reutilisee par les categories de chambres
        // (wifi, piscine, climatisation...) ET par les logements (douche interne, eau...)
        Schema::create('equipements', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->unique();
            $table->string('icone')->nullable();
            $table->enum('contexte', ['hotel', 'logement', 'les_deux'])->default('les_deux');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipements');
    }
};
