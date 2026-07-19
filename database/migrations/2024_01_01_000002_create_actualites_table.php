<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('actualites', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->text('description');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->string('image')->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // admin auteur
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('actualites');
    }
};
