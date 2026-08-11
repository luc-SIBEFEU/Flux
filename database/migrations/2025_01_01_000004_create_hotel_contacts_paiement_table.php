<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Numeros MTN MoMo / Orange Money sur lesquels l'hotelier recoit les paiements
        Schema::create('hotel_contact_paiements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained('hotels')->cascadeOnDelete();
            $table->enum('type', ['mtn_momo', 'orange_money']);
            $table->string('numero');
            $table->string('nom_titulaire')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hotel_contact_paiements');
    }
};
