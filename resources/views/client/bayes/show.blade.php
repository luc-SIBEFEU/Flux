@extends('layouts.dashboard')
@php $espaceRole = 'client'; @endphp
@section('titre_page', __('baye.detail_location'))
@section('titre', __('baye.ma_location_titre'))

@section('contenu')

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white border border-black/10 rounded-2xl p-6">
            <h2 class="font-display text-2xl capitalize">{{ $baye->logement->type }} — {{ $baye->logement->quartier }}</h2>
            <p class="text-sm text-flux-noir/50 flex items-center gap-1 mt-1"><x-icon name="map-pin" class="w-4 h-4" /> {{ $baye->logement->ville }}</p>

            <div class="grid grid-cols-2 gap-4 mt-5">
                <div class="bg-flux-brume rounded-xl p-4">
                    <p class="text-xs text-flux-noir/40">{{ __('baye.debut_bail') }}</p>
                    <p class="font-medium">{{ $baye->date_debut->format('d/m/Y') }}</p>
                </div>
                <div class="bg-flux-brume rounded-xl p-4">
                    <p class="text-xs text-flux-noir/40">{{ __('baye.fin_prevue') }}</p>
                    <p class="font-medium">{{ $baye->date_fin_prevue->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white border border-black/10 rounded-2xl p-6">
            <h3 class="font-medium mb-4">{{ __('baye.echeances_loyer') }}</h3>
            <div class="divide-y divide-black/5">
                @forelse($baye->loyers as $loyer)
                    <div class="flex items-center justify-between py-3">
                        <div>
                            <p class="font-medium text-sm">
                                @if($loyer->paiement_initial)
                                    {{ __('baye.paiement_initial_label') }}
                                @else
                                    {{ \Carbon\Carbon::parse($loyer->mois_concerne)->translatedFormat('F Y') }}
                                @endif
                            </p>
                            <p class="text-xs text-flux-noir/40">{{ __('baye.echeance') }} : {{ $loyer->date_echeance->format('d/m/Y') }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="font-medium text-flux-violet text-sm">{{ number_format($loyer->montant,0,',',' ') }} F</span>
                            @if($loyer->statut === 'paye')
                                <span class="text-xs px-2.5 py-1 rounded-full bg-flux-bleu-pale text-flux-bleu font-medium">{{ __('baye.paye') }}</span>
                            @else
                                <a href="{{ route('client.loyers.payer', $loyer) }}" class="text-xs px-3 py-1.5 rounded-full bg-flux-or text-flux-noir font-semibold">{{ __('baye.payer') }}</a>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-flux-noir/40 py-3">{{ __('baye.aucune_echeance') }}</p>
                @endforelse
            </div>
        </div>
    </div>

    <aside class="space-y-6">
        <div class="bg-white border border-black/10 rounded-2xl p-6">
            <h3 class="font-medium mb-3">{{ __('baye.prolonger_contrat') }}</h3>
            <form action="{{ route('client.bayes.prolonger', $baye) }}" method="POST" class="space-y-3">
                @csrf
                <input type="number" name="duree_supplementaire_mois" min="1" required placeholder="{{ __('baye.nombre_de_mois') }}"
                       class="w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-violet">
                <button class="w-full bg-flux-violet text-white text-sm font-semibold py-2.5 rounded-lg">{{ __('baye.demander_prolongation') }}</button>
            </form>

            @if($baye->prolongations->isNotEmpty())
                <div class="mt-4 space-y-2">
                    @foreach($baye->prolongations as $p)
                        <div class="text-xs bg-flux-brume rounded-lg px-3 py-2 flex items-center justify-between">
                            <span>+{{ $p->duree_supplementaire_mois }} {{ __('common.mois_abrege') }}</span>
                            <span class="font-medium">{{ __('baye.prolongation_statut_' . $p->statut) }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </aside>
</div>
@endsection
