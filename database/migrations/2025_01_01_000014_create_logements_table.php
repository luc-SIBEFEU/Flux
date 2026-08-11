<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('logements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bailleur_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('minicite_id')->nullable()->constrained('minicites')->nullOnDelete();
            // quand un logement est genere automatiquement depuis une mini-cite
            // (le bailleur possede N chambres du meme type), on garde une reference
            // au "modele" d'origine pour retrouver le groupe
            $table->foreignId('logement_modele_id')->nullable()->constrained('logements')->nullOnDelete();

            $table->enum('type', ['chambre', 'studio', 'appartement', 'villa']);
            $table->enum('categorie', ['standard', 'meuble']);
            $table->string('ville');
            $table->string('quartier');
            $table->string('google_map_lien')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->decimal('prix_mois', 10, 2);
            $table->decimal('caution', 10, 2)->default(0);
            $table->unsignedTinyInteger('duree_min_mois')->default(1);
            $table->text('info')->nullable();
            // un logement loue disparait automatiquement des resultats publics
            $table->enum('statut', ['disponible', 'loue'])->default('disponible');
            $table->timestamps();

            $table->index(['type', 'categorie', 'statut']);
            $table->index(['ville', 'quartier']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logements');
    }
};
