@extends('layouts.dashboard')
@php $espaceRole = auth()->user()->role; @endphp
@section('titre_page', __('forfait.mon_forfait'))
@section('titre', __('forfait.mon_forfait') . ' — Flux')

@section('contenu')

@php
    $estPro = $user->estEnForfaitPro();
    $enEssai = $user->estEnEssaiPro();
@endphp

<div class="bg-white border border-black/10 rounded-2xl p-6 mb-8">
    <div class="flex items-center justify-between flex-wrap gap-3">
        <div>
            <span class="text-xs uppercase tracking-wide text-flux-noir/40">{{ __('forfait.forfait_actuel') }}</span>
            <div class="flex items-center gap-2 mt-1">
                <span class="font-display text-2xl">{{ $user->forfait->nom}}</span>
                @if ($enEssai)
                    <span class="text-xs px-2.5 py-1 rounded-full font-medium bg-flux-or/20 text-flux-or">{{ __('forfait.essai_gratuit') }}</span>
                @elseif ($estPro)
                    <span class="text-xs px-2.5 py-1 rounded-full font-medium bg-flux-bleu-pale text-flux-bleu">{{ __('forfait.actif') }}</span>
                @else
                    <span class="text-xs px-2.5 py-1 rounded-full font-medium bg-flux-noir/5 text-flux-noir/60">{{ __('forfait.free') }}</span>
                @endif
            </div>
            @if ($user->forfait_expire_le)
                <p class="text-sm text-flux-noir/60 mt-2">
                    {{ $enEssai ? __('forfait.essai_valable_jusquau') : __('forfait.valable_jusquau') }}
                    {{ $user->forfait_expire_le->format('d/m/Y') }}.
                </p>
            @endif
        </div>

        @if (! $estPro && $user->peutDemarrerEssaiPro())
            <form method="POST" action="{{ route('forfait.essai') }}">
                @csrf
                <button class="px-4 py-2.5 rounded-xl bg-flux-or text-flux-noir text-sm font-medium">{{ __('forfait.demarrer_essai') }}</button>
            </form>
        @endif
    </div>

    @unless ($estPro)
        <p class="text-sm text-flux-noir/60 mt-4">
            {{ __('forfait.free_desc') }}
        </p>
    @endunless
</div>

<div class="flex items-end justify-between gap-4 flex-wrap mb-6">
    <div>
        <h2 class="font-display text-2xl text-flux-noir">{{ __('forfait.choisissez_formule') }}</h2>
        <p class="text-sm text-flux-noir/60 mt-2">{{ __('forfait.developpez_activite') }}</p>
    </div>
    <span class="inline-flex items-center gap-2 text-xs font-medium text-flux-bleu bg-flux-bleu-pale px-3 py-2 rounded-full">
        <x-icon name="check-circle" class="w-4 h-4" /> {{ __('forfait.paiement_securise') }}
    </span>
</div>

@php
    $avantages = [
        'pro_mensuel' => [
            'inclus' => [__('forfait.avantage_reservation_ligne'), __('forfait.avantage_paiement_aangaraa'), __('forfait.avantage_gestion_bayes'), __('forfait.avantage_reversement_auto')],
            'exclus' => [__('forfait.avantage_2mois_offerts')],
        ],
        'pro_annuel' => [
            'inclus' => [__('forfait.avantage_reservation_ligne'), __('forfait.avantage_paiement_aangaraa'), __('forfait.avantage_gestion_bayes'), __('forfait.avantage_reversement_auto'), __('forfait.avantage_2mois_offerts')],
            'exclus' => [],
        ],
    ];
@endphp

<div class="grid md:grid-cols-2 gap-6 max-w-4xl">
    @foreach ($offres as $offre)
        @php
            $estAnnuel = $offre->code === 'pro_annuel';
            $listeAvantages = $avantages[$offre->code] ?? ['inclus' => [], 'exclus' => []];
        @endphp
        <div class="bg-white border {{ $estAnnuel ? 'border-flux-violet' : 'border-black/10' }} rounded-2xl overflow-hidden flex flex-col shadow-sm">
            <div class="{{ $estAnnuel ? 'bg-flux-violet' : 'bg-flux-bleu' }} text-white px-6 py-5 text-center relative">
                @if ($estAnnuel)
                    <span class="absolute top-3 right-3 bg-flux-or text-flux-noir text-[10px] uppercase tracking-wide font-bold px-2.5 py-1 rounded-full">{{ __('forfait.populaire') }}</span>
                @endif
                <p class="text-white/70 text-xs uppercase tracking-[0.18em]">{{ __('forfait.formule_pro') }}</p>
                <h3 class="font-display text-2xl mt-1">{{ $offre->nom }}</h3>
                <div class="mt-4 flex items-baseline justify-center gap-2">
                    <span class="font-display text-4xl font-semibold">{{ number_format($offre->prix, 0, ',', ' ') }}</span>
                    <span class="text-sm text-white/70">FCFA / {{ $offre->periodicite === 'annuel' ? __('forfait.an') : __('forfait.mois') }}</span>
                </div>
            </div>
            <div class="p-6 flex flex-col flex-1">
                <p class="text-sm text-flux-noir/60 leading-relaxed min-h-12">{{ $offre->description }}</p>
                <ul class="space-y-3 mt-6 mb-7 text-sm">
                    @foreach ($listeAvantages['inclus'] as $avantage)
                        <li class="flex items-start gap-2 text-flux-noir/75">
                            <x-icon name="check-circle" class="w-4 h-4 text-emerald-500 shrink-0 mt-0.5" /> {{ $avantage }}
                        </li>
                    @endforeach
                    @foreach ($listeAvantages['exclus'] as $avantage)
                        <li class="flex items-start gap-2 text-flux-noir/40">
                            <x-icon name="x-circle" class="w-4 h-4 text-red-400 shrink-0 mt-0.5" /> {{ $avantage }}
                        </li>
                    @endforeach
                </ul>
                <form method="POST" action="{{ route('forfait.souscrire', $offre) }}" class="mt-auto">
                    @csrf
                    <button class="w-full px-4 py-3 rounded-lg bg-flux-or hover:bg-flux-or-vif text-flux-noir text-sm font-bold uppercase tracking-wide transition-colors">
                        {{ __('forfait.choisir_forfait') }}
                    </button>
                </form>
            </div>
        </div>
    @endforeach
</div>
@endsection
