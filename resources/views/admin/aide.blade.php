@extends('layouts.dashboard')
@php($espaceRole = 'admin')
@section('titre_page', 'Guide & notice')
@section('titre', 'Guide — Admin')

@section('contenu')
<div class="max-w-3xl space-y-8">

    <div class="bg-white border border-black/10 rounded-2xl p-6">
        <h2 class="font-display text-xl mb-3 flex items-center gap-2"><x-icon name="check-circle" class="w-5 h-5 text-flux-bleu" /> Validations à effectuer</h2>
        <ul class="space-y-2 text-sm text-flux-noir/70 list-disc list-inside">
            <li><strong>Comptes à valider</strong> : chaque inscription hôtelier/bailleur doit être examinée avant que la personne puisse se connecter. Vous recevez un e-mail à chaque nouvelle demande.</li>
            <li><strong>Hôtels à valider</strong> : un hôtel créé par un hôtelier n'est visible sur le site qu'après votre approbation.</li>
            <li><strong>Logements à valider</strong> : même principe pour les logements ajoutés par les bailleurs — y compris après une modification.</li>
            <li>En cas de rejet, indiquez toujours un motif : il est transmis par e-mail à la personne concernée.</li>
        </ul>
    </div>

    <div class="bg-white border border-black/10 rounded-2xl p-6">
        <h2 class="font-display text-xl mb-3 flex items-center gap-2"><x-icon name="star" class="w-5 h-5 text-flux-or" /> Modération</h2>
        <p class="text-sm text-flux-noir/70">Les avis clients sur les hôtels n'apparaissent publiquement qu'après votre approbation dans « Modération des avis ». La note moyenne de l'hôtel est recalculée automatiquement à chaque validation.</p>
    </div>

    <div class="bg-white border border-black/10 rounded-2xl p-6">
        <h2 class="font-display text-xl mb-3 flex items-center gap-2"><x-icon name="cog" class="w-5 h-5 text-flux-noir/60" /> Consultation en lecture seule</h2>
        <p class="text-sm text-flux-noir/70">« Tous les hôtels », « Tous les logements », « Tous les baux » et « Toutes les réservations » vous donnent une vue complète sur l'activité de la plateforme. Vous pouvez tout consulter mais rien modifier directement — la gestion reste entre les mains de l'hôtelier, du bailleur ou du client concerné.</p>
    </div>

    <div class="bg-white border border-black/10 rounded-2xl p-6">
        <h2 class="font-display text-xl mb-3 flex items-center gap-2"><x-icon name="coins" class="w-5 h-5 text-flux-or" /> Rapports financiers</h2>
        <p class="text-sm text-flux-noir/70">Le revenu total, la répartition par hôtel et par ville sont calculés à partir des paiements confirmés (MTN MoMo / Orange Money). Les paiements en attente ou échoués n'y figurent pas.</p>
    </div>

    <div class="bg-white border border-black/10 rounded-2xl p-6">
        <h2 class="font-display text-xl mb-3 flex items-center gap-2"><x-icon name="bell" class="w-5 h-5 text-flux-bleu" /> Automatisations</h2>
        <p class="text-sm text-flux-noir/70">Deux tâches planifiées tournent chaque jour : la clôture des séjours (envoi du pro-forma) et le traitement des baux expirés (libération du logement une fois le moratoire écoulé). Elles doivent être exécutées via <code class="bg-flux-brume px-1.5 py-0.5 rounded">php artisan schedule:work</code> ou une tâche cron.</p>
    </div>

</div>
@endsection
