<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Dénormalisé depuis "abonnements" pour des contrôles d'accès rapides
            // (middleware ForfaitPro, affichage badge dashboard, etc.). Uniquement
            // pertinent pour hotelier/bailleur ; reste null pour admin/client.
            $table->foreignId('forfait_id')->nullable()->after('role')->constrained('forfaits')->nullOnDelete();
            $table->date('forfait_expire_le')->nullable()->after('forfait_id');
            $table->boolean('essai_pro_utilise')->default(false)->after('forfait_expire_le');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('forfait_id');
            $table->dropColumn(['forfait_expire_le', 'essai_pro_utilise']);
        });
    }
};
