<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // AangaraaPay expose un vrai endpoint de retrait (disbursement) : chaque
        // paiement réussi pour une réservation/loyer (donc forcément en forfait
        // pro) déclenche automatiquement un versement vers le contact de paiement
        // de l'hôtelier/bailleur. Cette table trace chaque tentative ; l'admin
        // intervient seulement si ça échoue ou reste bloqué en attente.
        Schema::create('transferts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paiement_id')->constrained('paiements')->cascadeOnDelete();
            $table->foreignId('beneficiaire_id')->constrained('users')->cascadeOnDelete(); // hotelier ou bailleur
            $table->decimal('montant', 10, 2);
            $table->enum('type_contact', ['mtn_momo', 'orange_money'])->nullable();
            $table->string('numero_destinataire')->nullable();
            $table->enum('statut', ['a_traiter', 'en_cours', 'effectue', 'echoue'])->default('a_traiter');
            $table->string('reference_retrait')->nullable(); // reference_id renvoyé par /aangaraa-pay/withdrawal
            $table->timestamp('traite_le')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['beneficiaire_id', 'statut']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transferts');
    }
};
