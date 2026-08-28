<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            // Distinct de `statut` (cycle de vie du séjour). Reflète exactement le
            // dernier retour de l'API aangaraa-pay pour le paiement lié à cette
            // réservation, afin d'être affiché tel quel sur les dashboards et de
            // savoir si un bouton "Réessayer le paiement" doit être proposé.
            $table->enum('statut_paiement', ['en_attente', 'reussi', 'echoue', 'rembourse'])
                ->default('en_attente')
                ->after('statut');
        });
    }

    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn('statut_paiement');
        });
    }
};
