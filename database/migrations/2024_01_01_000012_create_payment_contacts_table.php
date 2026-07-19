<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotelier_id')->constrained('users')->cascadeOnDelete();
            $table->string('mtn_momo_numero')->nullable();
            $table->string('orange_money_numero')->nullable();
            $table->timestamps();

            $table->unique('hotelier_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_contacts');
    }
};
