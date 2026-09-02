@extends('layouts.app')
@section('titre', __('reservation_form.reserver') . ' — ' . $hotel->nom)

@section('contenu')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
    <p class="text-flux-bleu text-sm font-medium uppercase tracking-wide">{{ $hotel->nom }}</p>
    <h1 class="font-display text-3xl text-flux-noir mb-8">{{ __('reservation_form.finaliser_reservation') }}</h1>

    <div class="bg-white border border-black/10 rounded-2xl p-6 mb-6 flex items-center gap-4">
        <img src="{{ asset('storage/'.$hotel->image_couverture) }}" class="w-20 h-20 rounded-xl object-cover">
        <div>
            <h3 class="font-medium">{{ $categorieChambre->nom }}</h3>
            <p class="text-sm text-flux-noir/50">{{ $hotel->ville }} · {{ number_format($categorieChambre->prix_nuit, 0, ',', ' ') }} FCFA{{ __('chambre.par_nuit') }}</p>
        </div>
    </div>

    <form action="{{ route('reservations.store', $categorieChambre) }}" method="POST"
          x-data="calculTotal('{{ $categorieChambre->prix_nuit }}', '{{ request('date_arrivee') }}', '{{ request('date_depart') }}')"
          class="bg-white border border-black/10 rounded-2xl p-6 space-y-5">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label class="text-xs font-medium text-flux-noir/50">{{ __('reservation_form.date_arrivee') }}</label>
                <input type="date" name="date_arrivee" x-model="arrivee" required
                       class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
            </div>
            <div>
                <label class="text-xs font-medium text-flux-noir/50">{{ __('reservation_form.date_depart') }}</label>
                <input type="date" name="date_depart" x-model="depart" required
                       class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
            </div>
            <div>
                <label class="text-xs font-medium text-flux-noir/50">{{ __('reservation_form.adultes_max', ['n' => $categorieChambre->capacite_adultes]) }}</label>
                <input type="number" name="nombre_adultes" min="1" max="{{ $categorieChambre->capacite_adultes }}" value="{{ request('adultes', 1) }}"
                       class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
            </div>
            <div>
                <label class="text-xs font-medium text-flux-noir/50">{{ __('reservation_form.enfants_max', ['n' => $categorieChambre->capacite_enfants]) }}</label>
                <input type="number" name="nombre_enfants" min="0" max="{{ $categorieChambre->capacite_enfants }}" value="{{ request('enfants', 0) }}"
                       class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
            </div>
        </div>
        <div>
            <label class="text-xs font-medium text-flux-noir/50">{{ __('reservation_form.numero_telephone') }}</label>
            <div class="flex items-center gap-2 mt-1 border border-black/10 rounded-lg px-3 py-2.5">
                <x-icon name="phone" class="w-4 h-4 text-flux-bleu shrink-0" />
                <input type="tel" name="telephone_client" required placeholder="+237 6XX XXX XXX" class="w-full outline-none text-sm">
            </div>
        </div>

        <!-- Récapitulatif du coût, calculé en direct -->
        <div class="bg-flux-bleu-pale rounded-xl p-4 flex items-center justify-between">
            <div>
                <p class="text-xs text-flux-bleu/70" x-show="nuits > 0" x-text="nuits + ' ' + nuitLabel + ' × ' + prixNuit.toLocaleString('fr-FR') + ' FCFA'"></p>
                <p class="text-xs text-flux-bleu/70" x-show="nuits === 0">{{ __('reservation_form.selectionnez_dates') }}</p>
            </div>
            <p class="font-display text-2xl text-flux-bleu" x-text="total.toLocaleString('fr-FR') + ' FCFA'"></p>
        </div>

        <button type="submit" class="w-full bg-flux-or hover:bg-flux-or-vif text-flux-noir font-semibold py-3 rounded-lg transition-colors">
            {{ __('reservation_form.valider_reservation') }}
        </button>
        <p class="text-xs text-center text-flux-noir/40">{{ __('reservation_form.paiement_etape_suivante') }}</p>
    </form>
</div>

<script>
function calculTotal(prixNuit, arriveeInit, departInit) {
    return {
        prixNuit: parseFloat(prixNuit),
        arrivee: arriveeInit,
        depart: departInit,
        nuitLabel: @json(__('reservation_form.nuit_s')),
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
