<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->constrained()->cascadeOnDelete();
            $table->enum('methode', ['mtn_momo', 'orange_money']);
            $table->string('telephone_paiement');
            $table->decimal('montant', 10, 2);
            $table->string('reference_transaction')->nullable()->unique(); // renvoyée par Aangaraa Pay
            $table->enum('statut', ['initie', 'reussi', 'echoue'])->default('initie');
            $table->json('reponse_api')->nullable(); // payload brut de la réponse pour debug
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
