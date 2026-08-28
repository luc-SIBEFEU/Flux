<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // En forfait free, un hôtel/logement n'est pas réservable en ligne : le
        // client connecté voit la fiche et contacte le propriétaire (hôtelier ou
        // bailleur). Table polymorphique (contactable = Hotel | Logement) pour
        // couvrir les deux cas avec un seul flux (mail + notification dashboard).
        Schema::create('messages_contact', function (Blueprint $table) {
            $table->id();
            $table->morphs('contactable'); // contactable_id, contactable_type (Hotel | Logement)
            $table->foreignId('client_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('destinataire_id')->constrained('users')->cascadeOnDelete(); // hotelier_id ou bailleur_id
            $table->string('telephone_client');
            $table->text('message');
            $table->boolean('lu')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages_contact');
    }
};
