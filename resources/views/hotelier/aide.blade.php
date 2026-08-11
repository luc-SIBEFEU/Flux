@extends('layouts.dashboard')
@php($espaceRole = 'hotelier')
@section('titre_page', 'Guide & notice')
@section('titre', 'Guide — Hôtelier')

@section('contenu')
<div class="max-w-3xl space-y-8">

    <div class="bg-white border border-black/10 rounded-2xl p-6">
        <h2 class="font-display text-xl mb-3 flex items-center gap-2"><x-icon name="building" class="w-5 h-5 text-flux-bleu" /> Créer un hôtel</h2>
        <ul class="space-y-2 text-sm text-flux-noir/70 list-disc list-inside">
            <li>Renseignez le nom, la ville, le nombre d'étoiles et une image de couverture.</li>
            <li>Votre hôtel n'est <strong>pas visible immédiatement</strong> : il passe en attente de validation par un administrateur. Vous recevez un e-mail dès qu'il est validé ou rejeté.</li>
            <li>Toute modification ultérieure repasse également l'hôtel en validation.</li>
            <li>Ajoutez ensuite la galerie photo, les réseaux sociaux et vos contacts de paiement (MTN MoMo / Orange Money) depuis la fiche de l'hôtel.</li>
        </ul>
    </div>

    <div class="bg-white border border-black/10 rounded-2xl p-6">
        <h2 class="font-display text-xl mb-3 flex items-center gap-2"><x-icon name="key" class="w-5 h-5 text-flux-bleu" /> Catégories de chambres</h2>
        <p class="text-sm text-flux-noir/70">Chaque hôtel peut avoir plusieurs catégories de chambres (nom, capacité, prix par nuit, équipements). C'est ce que les clients réservent depuis la fiche de votre hôtel.</p>
    </div>

    <div class="bg-white border border-black/10 rounded-2xl p-6">
        <h2 class="font-display text-xl mb-3 flex items-center gap-2"><x-icon name="calendar" class="w-5 h-5 text-flux-bleu" /> Réservations</h2>
        <ul class="space-y-2 text-sm text-flux-noir/70 list-disc list-inside">
            <li>Une réservation client apparaît « en attente » jusqu'à confirmation de son paiement.</li>
            <li>Vous pouvez confirmer ou annuler une réservation manuellement si besoin.</li>
            <li>À la date de départ, le séjour est automatiquement clôturé : vous recevez un e-mail, et le client reçoit son pro-forma.</li>
        </ul>
    </div>

    <div class="bg-white border border-black/10 rounded-2xl p-6">
        <h2 class="font-display text-xl mb-3 flex items-center gap-2"><x-icon name="star" class="w-5 h-5 text-flux-or" /> Avis clients</h2>
        <p class="text-sm text-flux-noir/70">Les avis affichés ont été approuvés par un administrateur. Vous pouvez les consulter mais pas les modifier.</p>
    </div>

</div>
@endsection
