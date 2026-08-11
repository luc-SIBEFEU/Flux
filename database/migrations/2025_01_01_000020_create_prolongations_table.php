<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Historique des demandes de prolongation d'un contrat de baye
        Schema::create('prolongations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('baye_id')->constrained('bayes')->cascadeOnDelete();
            $table->unsignedSmallInteger('duree_supplementaire_mois');
            $table->date('nouvelle_date_fin_prevue')->nullable();
            $table->enum('statut', ['en_attente', 'approuvee', 'rejetee'])->default('en_attente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prolongations');
    }
};
