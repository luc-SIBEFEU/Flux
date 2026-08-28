@extends('layouts.dashboard')
@php $espaceRole = auth()->user()->role; @endphp
@section('titre_page', 'Mon forfait')
@section('titre', 'Forfait — Flux')

@section('contenu')

@php
    $estPro = $user->estEnForfaitPro();
    $enEssai = $user->estEnEssaiPro();
@endphp

<div class="bg-white border border-black/10 rounded-2xl p-6 mb-8">
    <div class="flex items-center justify-between flex-wrap gap-3">
        <div>
            <span class="text-xs uppercase tracking-wide text-flux-noir/40">Forfait actuel</span>
            <div class="flex items-center gap-2 mt-1">
                <span class="font-display text-2xl">{{ $user->forfait->nom}}</span>
                @if ($enEssai)
                    <span class="text-xs px-2.5 py-1 rounded-full font-medium bg-flux-or/20 text-flux-or">Essai gratuit</span>
                @elseif ($estPro)
                    <span class="text-xs px-2.5 py-1 rounded-full font-medium bg-flux-bleu-pale text-flux-bleu">Actif</span>
                @else
                    <span class="text-xs px-2.5 py-1 rounded-full font-medium bg-flux-noir/5 text-flux-noir/60">Free</span>
                @endif
            </div>
            @if ($user->forfait_expire_le)
                <p class="text-sm text-flux-noir/60 mt-2">
                    {{ $enEssai ? "Essai valable jusqu'au" : "Valable jusqu'au" }}
                    {{ $user->forfait_expire_le->format('d/m/Y') }}.
                </p>
            @endif
        </div>

        @if (! $estPro && $user->peutDemarrerEssaiPro())
            <form method="POST" action="{{ route('forfait.essai') }}">
                @csrf
                <button class="px-4 py-2.5 rounded-xl bg-flux-or text-flux-noir text-sm font-medium">Démarrer l'essai gratuit de 14 jours</button>
            </form>
        @endif
    </div>

    @unless ($estPro)
        <p class="text-sm text-flux-noir/60 mt-4">
            En forfait free, vos hôtels/logements sont visibles sur Flux mais ne sont pas réservables en ligne :
            les clients vous contactent directement (par e-mail et depuis votre espace « Messages »).
        </p>
    @endunless
</div>

<div class="flex items-end justify-between gap-4 flex-wrap mb-6">
    <div>
        <h2 class="font-display text-2xl text-flux-noir">Choisissez votre formule</h2>
        <p class="text-sm text-flux-noir/60 mt-2">Développez votre activité avec les outils adaptés à votre établissement.</p>
    </div>
    <span class="inline-flex items-center gap-2 text-xs font-medium text-flux-bleu bg-flux-bleu-pale px-3 py-2 rounded-full">
        <x-icon name="check-circle" class="w-4 h-4" /> Paiement sécurisé
    </span>
</div>

@php
    $avantages = [
        'pro_mensuel' => [
            'inclus' => ['Réservation en ligne', 'Paiement AangaraaPay', 'Gestion des bayes', 'Reversement automatique'],
            'exclus' => ['2 mois offerts'],
        ],
        'pro_annuel' => [
            'inclus' => ['Réservation en ligne', 'Paiement AangaraaPay', 'Gestion des bayes', 'Reversement automatique', '2 mois offerts'],
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
                    <span class="absolute top-3 right-3 bg-flux-or text-flux-noir text-[10px] uppercase tracking-wide font-bold px-2.5 py-1 rounded-full">Populaire</span>
                @endif
                <p class="text-white/70 text-xs uppercase tracking-[0.18em]">Formule pro</p>
                <h3 class="font-display text-2xl mt-1">{{ $offre->nom }}</h3>
                <div class="mt-4 flex items-baseline justify-center gap-2">
                    <span class="font-display text-4xl font-semibold">{{ number_format($offre->prix, 0, ',', ' ') }}</span>
                    <span class="text-sm text-white/70">FCFA / {{ $offre->periodicite === 'annuel' ? 'an' : 'mois' }}</span>
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
                        Choisir ce forfait
                    </button>
                </form>
            </div>
        </div>
    @endforeach
</div>
@endsection
