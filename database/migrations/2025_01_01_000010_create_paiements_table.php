<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Table polymorphique: reutilisee pour payer une reservation d'hotel
        // OU un loyer (voir table "loyers"). Integration API aangaraa-pay.com
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->morphs('payable'); // payable_id, payable_type (Reservation | Loyer)
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // qui paie
            $table->decimal('montant', 10, 2);
            $table->enum('methode', ['mtn_momo', 'orange_money']);
            $table->string('numero_expediteur')->nullable();
            $table->string('reference_transaction')->nullable()->unique(); // ref renvoyee par aangaraa-pay
            $table->enum('statut', ['en_attente', 'reussi', 'echoue', 'rembourse'])->default('en_attente');
            $table->json('reponse_api')->nullable(); // payload brut de reponse de l'API
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
