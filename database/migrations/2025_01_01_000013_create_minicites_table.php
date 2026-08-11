<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('minicites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bailleur_id')->constrained('users')->cascadeOnDelete();
            $table->string('nom');
            $table->string('ville');
            $table->string('quartier');
            $table->string('google_map_lien')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->text('info')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('minicites');
    }
};
