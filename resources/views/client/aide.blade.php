@extends('layouts.dashboard')
@php($espaceRole = 'client')
@section('titre_page', 'Guide & notice')
@section('titre', 'Guide — Mon espace')

@section('contenu')
<div class="max-w-3xl space-y-8">

    <div class="bg-white border border-black/10 rounded-2xl p-6">
        <h2 class="font-display text-xl mb-3 flex items-center gap-2"><x-icon name="calendar" class="w-5 h-5 text-flux-bleu" /> Réserver un hôtel</h2>
        <ul class="space-y-2 text-sm text-flux-noir/70 list-disc list-inside">
            <li>Le coût total s'affiche en direct sur le formulaire de réservation dès que vous choisissez vos dates.</li>
            <li>Après validation, vous êtes redirigé vers le paiement (MTN MoMo ou Orange Money) : un message est envoyé sur votre téléphone à approuver.</li>
            <li>Votre réservation passe en « confirmée » dès que le paiement est validé.</li>
            <li>Une fois votre séjour terminé, un pro-forma vous est envoyé par e-mail et reste téléchargeable depuis « Mes réservations ».</li>
        </ul>
    </div>

    <div class="bg-white border border-black/10 rounded-2xl p-6">
        <h2 class="font-display text-xl mb-3 flex items-center gap-2"><x-icon name="key" class="w-5 h-5 text-flux-violet" /> Louer un logement</h2>
        <ul class="space-y-2 text-sm text-flux-noir/70 list-disc list-inside">
            <li>Depuis la fiche d'un logement, indiquez la durée souhaitée (au moins égale à la durée minimum exigée) et contactez le bailleur.</li>
            <li>Une fois le bailleur d'accord, vous devez régler un <strong>paiement initial</strong> qui couvre la caution et les mois de la durée minimum.</li>
            <li>Les mois suivants peuvent être payés <strong>à votre rythme</strong> (fin de mois, tous les deux mois...) depuis « Mes locations ».</li>
            <li>Vous pouvez demander une <strong>prolongation</strong> de votre bail ; elle doit être validée par le bailleur.</li>
            <li>À la fin du bail (moratoire inclus), un pro-forma récapitulatif vous est envoyé par e-mail.</li>
        </ul>
    </div>

    <div class="bg-white border border-black/10 rounded-2xl p-6">
        <h2 class="font-display text-xl mb-3 flex items-center gap-2"><x-icon name="heart" class="w-5 h-5 text-flux-violet" /> Favoris & avis</h2>
        <p class="text-sm text-flux-noir/70">Ajoutez des hôtels en favoris pour les retrouver facilement. Vos avis et notes sur un hôtel ou un logement sont visibles publiquement après modération (pour les hôtels) ou immédiatement (pour les logements).</p>
    </div>

</div>
@endsection
