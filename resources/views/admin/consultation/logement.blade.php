@extends('layouts.dashboard')
@php $espaceRole = 'admin'; @endphp
@section('titre_page', 'Détail du logement')
@section('titre', 'Logement — Consultation admin')

@section('contenu')

<a href="{{ route('admin.consultation.logements') }}" class="text-sm text-flux-noir/50 hover:text-flux-violet">← Retour aux logements</a>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white border border-black/10 rounded-2xl p-6">
            <h2 class="font-display text-2xl capitalize">{{ $logement->type }} — {{ $logement->quartier }}, {{ $logement->ville }}</h2>
            <p class="text-sm text-flux-noir/50 mt-1">{{ number_format($logement->prix_mois,0,',',' ') }} FCFA/mois · caution {{ number_format($logement->caution,0,',',' ') }} FCFA</p>
            <p class="text-sm text-flux-noir/50 mt-2">{{ $logement->info }}</p>
        </div>

        <div class="bg-white border border-black/10 rounded-2xl p-6">
            <h3 class="font-medium mb-4">Historique des baux ({{ $logement->bayes->count() }})</h3>
            <div class="divide-y divide-black/5">
                @forelse($logement->bayes as $baye)
                    <div class="flex items-center justify-between py-3 text-sm">
                        <span>{{ $baye->client->nom }} — {{ $baye->date_debut->format('d/m/Y') }}</span>
                        <span class="font-medium">{{ ucfirst(str_replace('_',' ',$baye->statut)) }}</span>
                    </div>
                @empty
                    <p class="text-sm text-flux-noir/40 py-3">Aucun bail pour ce logement.</p>
                @endforelse
            </div>
        </div>
    </div>

    <aside class="bg-white border border-black/10 rounded-2xl p-6 h-fit">
        <h3 class="font-medium mb-3">Bailleur</h3>
        <p class="text-sm">{{ $logement->bailleur->nom }}</p>
        <p class="text-sm text-flux-noir/50">{{ $logement->bailleur->email }}</p>
        <p class="text-sm text-flux-noir/50">{{ $logement->bailleur->telephone }}</p>
        @if($logement->minicite)
            <hr class="border-black/5 my-3">
            <p class="text-xs text-flux-noir/40">Mini-cité</p>
            <p class="text-sm">{{ $logement->minicite->nom }}</p>
        @endif
    </aside>
</div>
@endsection
