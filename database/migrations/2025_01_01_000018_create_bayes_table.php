<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Cree quand le bailleur valide une demande de baye (et paiement initial ok)
        Schema::create('bayes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('demande_baye_id')->nullable()->constrained('demandes_baye')->nullOnDelete();
            $table->foreignId('client_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('logement_id')->constrained('logements')->cascadeOnDelete();
            $table->foreignId('bailleur_id')->constrained('users')->cascadeOnDelete();
            $table->date('date_debut');
            $table->unsignedSmallInteger('duree_mois');
            $table->date('date_fin_prevue');
            $table->enum('statut', ['nouveau', 'en_cours', 'termine'])->default('nouveau');
            $table->enum('etat_paiement', ['a_jour', 'en_retard', 'solde'])->default('a_jour');
            $table->timestamps();

            $table->index(['bailleur_id', 'statut']);
            $table->index(['client_id', 'statut']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bayes');
    }
};
