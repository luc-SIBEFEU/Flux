@extends('layouts.app')
@section('titre', __('paiement.en_cours_titre') . ' — Flux')

@section('contenu')
<div class="max-w-md mx-auto px-4 py-20 text-center" x-data="paiementAttente('{{ route('paiements.statut', $paiement) }}', '{{ match($type) { 'reservation' => route('client.reservations.index'), 'abonnement' => route('forfait.index'), default => route('client.bayes.index') } }}')" x-init="demarrer()">
    <div class="w-16 h-16 rounded-full bg-flux-bleu-pale flex items-center justify-center mx-auto mb-6" :class="statut === 'reussi' && 'bg-flux-bleu'">
        <x-icon name="phone" class="w-8 h-8 text-flux-bleu" x-show="statut !== 'reussi'" />
        <x-icon name="check-circle" class="w-8 h-8 text-white" x-show="statut === 'reussi'" x-cloak />
    </div>

    <h1 class="font-display text-2xl mb-2" x-show="statut === 'en_attente'">{{ __('paiement.confirmez_telephone') }}</h1>
    <h1 class="font-display text-2xl mb-2" x-show="statut === 'reussi'" x-cloak>{{ __('paiement.confirme') }}</h1>
    <h1 class="font-display text-2xl mb-2" x-show="statut === 'echoue'" x-cloak>{{ __('paiement.echoue') }}</h1>

    <p class="text-flux-noir/50 text-sm" x-show="statut === 'en_attente'">
        {{ __('paiement.message_envoye_desc') }}
    </p>
    <p class="text-flux-noir/50 text-sm" x-show="statut === 'echoue'" x-cloak>
        {{ __('paiement.transaction_echouee_desc') }}
    </p>

    <div class="mt-8" x-show="statut === 'en_attente'">
        <svg class="animate-spin h-6 w-6 text-flux-bleu mx-auto" viewBox="0 0 24 24" fill="none">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
        </svg>
    </div>
</div>

<script>
function paiementAttente(urlStatut, urlRetour) {
    return {
        statut: 'en_attente',
        demarrer() {
            const interval = setInterval(async () => {
                const res = await fetch(urlStatut);
                const data = await res.json();
                this.statut = data.statut;
                if (data.statut === 'reussi') {
                    clearInterval(interval);
                    setTimeout(() => window.location.href = urlRetour, 1500);
                } else if (data.statut === 'echoue') {
                    clearInterval(interval);
                }
            }, 3000);
        }
    }
}
</script>
@endsection
