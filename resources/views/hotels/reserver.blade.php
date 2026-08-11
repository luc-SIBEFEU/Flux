@extends('layouts.app')
@section('titre', 'Réserver — ' . $hotel->nom)

@section('contenu')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
    <p class="text-flux-bleu text-sm font-medium uppercase tracking-wide">{{ $hotel->nom }}</p>
    <h1 class="font-display text-3xl text-flux-noir mb-8">Finaliser la réservation</h1>

    <div class="bg-white border border-black/10 rounded-2xl p-6 mb-6 flex items-center gap-4">
        <img src="{{ asset('storage/'.$hotel->image_couverture) }}" class="w-20 h-20 rounded-xl object-cover">
        <div>
            <h3 class="font-medium">{{ $categorieChambre->nom }}</h3>
            <p class="text-sm text-flux-noir/50">{{ $hotel->ville }} · {{ number_format($categorieChambre->prix_nuit, 0, ',', ' ') }} FCFA / nuit</p>
        </div>
    </div>

    <form action="{{ route('reservations.store', $categorieChambre) }}" method="POST"
          x-data="calculTotal('{{ $categorieChambre->prix_nuit }}', '{{ request('date_arrivee') }}', '{{ request('date_depart') }}')"
          class="bg-white border border-black/10 rounded-2xl p-6 space-y-5">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label class="text-xs font-medium text-flux-noir/50">Date d'arrivée</label>
                <input type="date" name="date_arrivee" x-model="arrivee" required
                       class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
            </div>
            <div>
                <label class="text-xs font-medium text-flux-noir/50">Date de départ</label>
                <input type="date" name="date_depart" x-model="depart" required
                       class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
            </div>
            <div>
                <label class="text-xs font-medium text-flux-noir/50">Adultes</label>
                <input type="number" name="nombre_adultes" min="1" max="{{ $categorieChambre->capacite_adultes }}" value="{{ request('adultes', 1) }}"
                       class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
            </div>
            <div>
                <label class="text-xs font-medium text-flux-noir/50">Enfants</label>
                <input type="number" name="nombre_enfants" min="0" max="{{ $categorieChambre->capacite_enfants }}" value="{{ request('enfants', 0) }}"
                       class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
            </div>
        </div>
        <div>
            <label class="text-xs font-medium text-flux-noir/50">Numéro de téléphone</label>
            <div class="flex items-center gap-2 mt-1 border border-black/10 rounded-lg px-3 py-2.5">
                <x-icon name="phone" class="w-4 h-4 text-flux-bleu shrink-0" />
                <input type="tel" name="telephone_client" required placeholder="+237 6XX XXX XXX" class="w-full outline-none text-sm">
            </div>
        </div>

        <!-- Récapitulatif du coût, calculé en direct -->
        <div class="bg-flux-bleu-pale rounded-xl p-4 flex items-center justify-between">
            <div>
                <p class="text-xs text-flux-bleu/70" x-show="nuits > 0" x-text="nuits + ' nuit(s) × ' + prixNuit.toLocaleString('fr-FR') + ' FCFA'"></p>
                <p class="text-xs text-flux-bleu/70" x-show="nuits === 0">Sélectionnez vos dates pour voir le total</p>
            </div>
            <p class="font-display text-2xl text-flux-bleu" x-text="total.toLocaleString('fr-FR') + ' FCFA'"></p>
        </div>

        <button type="submit" class="w-full bg-flux-or hover:bg-flux-or-vif text-flux-noir font-semibold py-3 rounded-lg transition-colors">
            Valider la réservation
        </button>
        <p class="text-xs text-center text-flux-noir/40">Le paiement (MTN MoMo / Orange Money) sera demandé à l'étape suivante.</p>
    </form>
</div>

<script>
function calculTotal(prixNuit, arriveeInit, departInit) {
    return {
        prixNuit: parseFloat(prixNuit),
        arrivee: arriveeInit,
        depart: departInit,
        get nuits() {
            if (!this.arrivee || !this.depart) return 0;
            const diff = (new Date(this.depart) - new Date(this.arrivee)) / (1000 * 60 * 60 * 24);
            return diff > 0 ? diff : 0;
        },
        get total() {
            return this.nuits * this.prixNuit;
        }
    }
}
</script>
@endsection
