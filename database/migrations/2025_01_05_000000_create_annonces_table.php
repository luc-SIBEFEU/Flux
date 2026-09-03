<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('annonces', function (Blueprint $table) {
            $table->id();
            // Auteur : hôtelier ou bailleur, forcément en forfait pro au moment de la publication.
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('titre');
            // Contenu saisi via l'éditeur de texte enrichi (HTML nettoyé côté serveur).
            $table->longText('contenu');
            $table->string('image')->nullable();
            $table->string('ville');
            // Catégorie libre pour filtrage : promotion, information, evenement, disponibilite, autre.
            $table->enum('categorie', ['promotion', 'information', 'evenement', 'disponibilite', 'autre'])->default('information');
            // L'admin peut masquer une annonce inappropriée sans la supprimer (modération légère).
            $table->boolean('visible')->default(true);
            // Date de fin d'affichage optionnelle.
            $table->date('expire_le')->nullable();
            $table->timestamps();

            $table->index(['ville', 'visible']);
            $table->index(['user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('annonces');
    }
};
