<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Un loyer = une echeance mensuelle a payer pour un baye donne.
        // Genere automatiquement (job/commande planifiee) mois par mois pendant le baye.
        Schema::create('loyers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('baye_id')->constrained('bayes')->cascadeOnDelete();
            $table->date('mois_concerne'); // ex: 2026-08-01
            $table->decimal('montant', 10, 2);
            $table->date('date_echeance');
            $table->enum('statut', ['en_attente', 'paye', 'en_retard'])->default('en_attente');
            $table->timestamp('date_paiement')->nullable();
            $table->timestamps();

            $table->unique(['baye_id', 'mois_concerne']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loyers');
    }
};
