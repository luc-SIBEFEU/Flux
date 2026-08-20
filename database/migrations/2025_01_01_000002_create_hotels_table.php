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
            $table->unsignedTinyInteger('nombre_etoiles'); // 1 a 5
            $table->decimal('note_moyenne', 3, 1)->default(0); // recalculee depuis avis_hotels
            $table->string('ville');
            $table->string('adresse')->nullable();
            $table->string('map')->nullable();
            // $table->decimal('latitude', 10, 7)->nullable();
            // $table->decimal('longitude', 10, 7)->nullable();
            $table->string('image_couverture');
            $table->text('description')->nullable();
            $table->enum('statut', ['en_attente', 'valide', 'rejete'])->default('en_attente');
            $table->text('motif_rejet')->nullable();
            $table->timestamps();

            $table->index(['ville', 'statut']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
