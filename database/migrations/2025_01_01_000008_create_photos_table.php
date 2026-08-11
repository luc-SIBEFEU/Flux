<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Table polymorphique: galerie photo des hotels, categories de chambres,
        // logements et mini-cites
        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            $table->morphs('photoable'); // photoable_id, photoable_type
            $table->string('chemin');
            $table->boolean('est_couverture')->default(false);
            $table->unsignedInteger('ordre')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('photos');
    }
};
