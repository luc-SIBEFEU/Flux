<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotelier_id')->constrained('users')->cascadeOnDelete();
            $table->string('nom');
            $table->unsignedTinyInteger('nombre_etoiles')->default(1); // 1 à 5
            $table->decimal('note_moyenne', 3, 2)->default(0); // cache calculé /10
            $table->unsignedInteger('nombre_avis')->default(0);
            $table->string('ville');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->text('adresse')->nullable();
            $table->text('description')->nullable();
            $table->string('image_couverture')->nullable();
            $table->string('logo')->nullable();

            // validation par l'admin : en_attente | valide | rejete
            $table->enum('statut', ['en_attente', 'valide', 'rejete'])->default('en_attente');

            $table->timestamps();

            $table->index(['ville', 'statut']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
