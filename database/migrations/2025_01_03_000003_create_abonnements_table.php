<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Historique de chaque période de forfait souscrite par un hôtelier/bailleur
        // (essai gratuit, ou période payée). users.forfait_id/forfait_expire_le
        // reflètent toujours la ligne "courante" (dénormalisation utile pour les
        // contrôles d'accès), cette table garde la trace complète + le paiement lié.
        Schema::create('abonnements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('forfait_id')->constrained('forfaits')->cascadeOnDelete();
            $table->enum('statut', ['en_attente', 'essai', 'actif', 'expire', 'annule'])->default('en_attente');
            $table->date('date_debut');
            $table->date('date_fin')->nullable(); // null tant que "free" ou essai en cours sans terme
            $table->timestamps();

            $table->index(['user_id', 'statut']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('abonnements');
    }
};
