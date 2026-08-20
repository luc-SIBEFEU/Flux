<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Cree quand un client clique sur "Contacter le bailleur"
        Schema::create('demande_bayes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('logement_id')->constrained('logements')->cascadeOnDelete();
            $table->foreignId('bailleur_id')->constrained('users')->cascadeOnDelete();
            $table->string('telephone_client')->nullable();
            $table->text('message')->nullable();
            $table->unsignedTinyInteger('duree_souhaitee_mois')->nullable();
            $table->enum('statut', ['nouveau', 'validee', 'rejetee'])->default('nouveau');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('demande_bayes');
    }
};
