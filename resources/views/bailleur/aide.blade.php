@extends('layouts.dashboard')
@php($espaceRole = 'bailleur')
@section('titre_page', 'Guide & notice')
@section('titre', 'Guide — Bailleur')

@section('contenu')
<div class="max-w-3xl space-y-8">

    <div class="bg-white border border-black/10 rounded-2xl p-6">
        <h2 class="font-display text-xl mb-3 flex items-center gap-2"><x-icon name="building" class="w-5 h-5 text-flux-violet" /> Ajouter un logement</h2>
        <ul class="space-y-2 text-sm text-flux-noir/70 list-disc list-inside">
            <li>Comme pour les hôtels, un logement n'est visible sur le site qu'après validation par un administrateur (à la création et après chaque modification).</li>
            <li><strong>Les villas sont automatiquement meublées</strong> — le champ catégorie se verrouille sur « meublé ».</li>
            <li>Vous pouvez regrouper plusieurs logements identiques dans une <strong>mini-cité</strong> et générer plusieurs exemplaires en une fois.</li>
            <li>Le <strong>moratoire</strong> (7 jours par défaut, modifiable par logement) est le délai après la fin d'un bail avant que le logement redevienne visible — le temps de le libérer ou qu'une prolongation soit demandée.</li>
        </ul>
    </div>

    <div class="bg-white border border-black/10 rounded-2xl p-6">
        <h2 class="font-display text-xl mb-3 flex items-center gap-2"><x-icon name="bell" class="w-5 h-5 text-flux-or" /> Demandes de baye</h2>
        <ul class="space-y-2 text-sm text-flux-noir/70 list-disc list-inside">
            <li>Quand un client vous contacte, une demande apparaît avec la durée souhaitée (au moins la durée minimum de votre logement).</li>
            <li>En validant, un bail est créé et un <strong>paiement initial</strong> (caution + durée minimum) est demandé au client ; le logement passe en « loué ».</li>
            <li>Les mois suivants sont payés par le client à son rythme — vous suivez l'état des paiements dans « Locations en cours ».</li>
        </ul>
    </div>

    <div class="bg-white border border-black/10 rounded-2xl p-6">
        <h2 class="font-display text-xl mb-3 flex items-center gap-2"><x-icon name="key" class="w-5 h-5 text-flux-violet" /> Prolongations & fin de bail</h2>
        <ul class="space-y-2 text-sm text-flux-noir/70 list-disc list-inside">
            <li>Toute demande de prolongation d'un client doit être <strong>validée par vous</strong> avant de s'appliquer.</li>
            <li>Une fois le bail terminé (moratoire écoulé), le logement redevient automatiquement visible sur le site — vous recevez un e-mail de confirmation avec le pro-forma récapitulatif du bail.</li>
        </ul>
    </div>

    <div class="bg-white border border-black/10 rounded-2xl p-6">
        <h2 class="font-display text-xl mb-3 flex items-center gap-2"><x-icon name="coins" class="w-5 h-5 text-flux-or" /> Recevoir vos loyers</h2>
        <p class="text-sm text-flux-noir/70">Ajoutez vos numéros MTN MoMo / Orange Money dans votre profil : c'est là que les paiements de vos locataires sont dirigés.</p>
    </div>

</div>
@endsection
