<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('hotel_id')->constrained()->cascadeOnDelete();
            $table->foreignId('room_category_id')->constrained()->cascadeOnDelete();

            $table->string('telephone_client');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->unsignedTinyInteger('nombre_adultes');
            $table->unsignedTinyInteger('nombre_enfants')->default(0);

            $table->decimal('prix_total', 10, 2);

            // en_attente : créée mais pas encore payée
            // confirmee : paiement validé
            // annulee : annulée par client/hôtelier/admin
            $table->enum('statut', ['en_attente', 'confirmee', 'annulee'])->default('en_attente');

            $table->timestamps();

            $table->index(['statut']);
            $table->index(['date_debut', 'date_fin']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
