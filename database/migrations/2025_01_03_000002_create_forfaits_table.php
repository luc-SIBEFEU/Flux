<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Une formule par "produit vendable" : free (gratuit, jamais expiré),
        // pro_mensuel et pro_annuel (prix + durée modifiables par l'admin
        // depuis son dashboard). On garde une table plutôt que des constantes
        // pour permettre à l'admin de changer le prix sans déploiement, et
        // d'ajouter facilement une autre périodicité plus tard.
        Schema::create('forfaits', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // free | pro_mensuel | pro_annuel
            $table->string('nom');
            $table->enum('type', ['free', 'pro'])->default('pro');
            $table->enum('periodicite', ['aucune', 'mensuel', 'annuel'])->default('aucune');
            $table->unsignedInteger('duree_jours')->nullable(); // null pour "free" (illimité)
            $table->decimal('prix', 10, 2)->default(0);
            $table->text('description')->nullable();
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('forfaits');
    }
};
