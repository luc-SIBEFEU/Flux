<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('email');
            $table->enum('type_demande', ['support', 'reservations', 'paiement', 'partenariat', 'autre'])->default('autre');
            $table->string('sujet');
            $table->text('message');
            $table->string('piece_jointe')->nullable();
            $table->text('reponse')->nullable();
            $table->dateTime('reponse_date')->nullable();
            $table->foreignId('repondu_par')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('lu')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
