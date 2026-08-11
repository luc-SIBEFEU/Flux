<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Vérification d'e-mail par code (inscription en deux étapes)
            $table->string('code_verification', 6)->nullable()->after('email_verified_at');
            $table->timestamp('code_expire_a')->nullable()->after('code_verification');

            // Validation du compte par l'admin (hôtelier / bailleur uniquement).
            // Les clients sont "non_requis" et actifs dès l'inscription.
            $table->enum('statut_validation', ['non_requis', 'en_attente', 'valide', 'rejete'])
                ->default('non_requis')->after('actif');
            $table->text('motif_rejet_compte')->nullable()->after('statut_validation');
        });

        Schema::table('logements', function (Blueprint $table) {
            // Validation admin du logement (indépendante de la disponibilité "statut")
            $table->enum('validation', ['en_attente', 'valide', 'rejete'])->default('en_attente')->after('statut');
            $table->text('motif_rejet')->nullable()->after('validation');

            // Délai de grâce (en jours) après la fin du bail avant remise en ligne du logement
            $table->unsignedSmallInteger('moratoire_jours')->default(7)->after('duree_min_mois');
        });

        Schema::table('bayes', function (Blueprint $table) {
            // Date de fin réelle incluant le moratoire (calculée à la création / prolongation)
            $table->date('date_fin_moratoire')->nullable()->after('date_fin_prevue');
            // PDF proforma généré à la fin du bail, accessible au client et au bailleur
            $table->string('proforma_pdf')->nullable()->after('etat_paiement');
        });

        Schema::table('reservations', function (Blueprint $table) {
            // PDF proforma généré à la fin du séjour, stocké sur le disque public
            $table->string('proforma_pdf')->nullable()->after('statut');
        });

        Schema::table('loyers', function (Blueprint $table) {
            // Distingue le paiement initial (caution + durée minimum) des mensualités libres
            $table->boolean('paiement_initial')->default(false)->after('statut');
        });

        Schema::table('actualites', function (Blueprint $table) {
            // Ordre d'affichage dans le carrousel du hero
            $table->unsignedInteger('ordre')->default(0)->after('image');
        });
    }

    public function down(): void
    {
        Schema::table('actualites', fn (Blueprint $t) => $t->dropColumn('ordre'));
        Schema::table('loyers', fn (Blueprint $t) => $t->dropColumn('paiement_initial'));
        Schema::table('reservations', fn (Blueprint $t) => $t->dropColumn('proforma_pdf'));
        Schema::table('bayes', fn (Blueprint $t) => $t->dropColumn(['date_fin_moratoire', 'proforma_pdf']));
        Schema::table('logements', fn (Blueprint $t) => $t->dropColumn(['validation', 'motif_rejet', 'moratoire_jours']));
        Schema::table('users', fn (Blueprint $t) => $t->dropColumn(['code_verification', 'code_expire_a', 'statut_validation', 'motif_rejet_compte']));
    }
};
