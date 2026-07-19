<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // 'api' : paiement initié via l'API MTN MoMo / Orange Money
            // 'manuel' : le client paie lui-même au numéro affiché et fournit une preuve
            $table->enum('mode', ['api', 'manuel'])->default('manuel')->after('methode');

            // référence de transaction saisie par le CLIENT lui-même en mode manuel
            // (reçue par SMS après son transfert MoMo/Orange Money)
            $table->string('preuve_paiement')->nullable()->after('reference_transaction');

            // audit de la confirmation manuelle par l'hôtelier/admin
            $table->foreignId('confirme_par_id')->nullable()->constrained('users')->nullOnDelete()->after('statut');
            $table->timestamp('confirme_le')->nullable()->after('confirme_par_id');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropConstrainedForeignId('confirme_par_id');
            $table->dropColumn(['mode', 'preuve_paiement', 'confirme_le']);
        });
    }
};
