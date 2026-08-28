<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Numeros MTN MoMo / Orange Money sur lesquels l'admin recoit le paiement
        // des forfaits pro (meme structure que hotel_contact_paiements /
        // bailleur_contact_paiements). Rattache a un compte admin precis puisqu'il
        // peut y en avoir plusieurs.
        Schema::create('admin_contact_paiements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('users')->cascadeOnDelete();
            $table->enum('type', ['mtn_momo', 'orange_money']);
            $table->string('numero');
            $table->string('nom_titulaire')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_contact_paiements');
    }
};
