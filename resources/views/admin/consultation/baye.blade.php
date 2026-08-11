@extends('layouts.dashboard')
@php $espaceRole = 'admin'; @endphp
@section('titre_page', 'Détail du bail')
@section('titre', 'Bail — Consultation admin')

@section('contenu')

<a href="{{ route('admin.consultation.bayes') }}" class="text-sm text-flux-noir/50 hover:text-flux-violet">← Retour aux baux</a>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white border border-black/10 rounded-2xl p-6">
            <h2 class="font-display text-2xl capitalize">{{ $baye->logement->type }} — {{ $baye->logement->quartier }}</h2>
            <p class="text-sm text-flux-noir/50 mt-1">{{ $baye->date_debut->format('d/m/Y') }} → {{ $baye->date_fin_prevue->format('d/m/Y') }} ({{ $baye->duree_mois }} mois)</p>
            @if($baye->date_fin_moratoire)
                <p class="text-xs text-flux-noir/40 mt-1">Fin de moratoire : {{ $baye->date_fin_moratoire->format('d/m/Y') }}</p>
            @endif
        </div>

        <div class="bg-white border border-black/10 rounded-2xl p-6">
            <h3 class="font-medium mb-4">Échéancier des loyers</h3>
            <div class="divide-y divide-black/5">
                @foreach($baye->loyers as $loyer)
                    <div class="flex items-center justify-between py-3 text-sm">
                        <span>{{ \Carbon\Carbon::parse($loyer->mois_concerne)->translatedFormat('F Y') }} @if($loyer->paiement_initial)<span class="text-xs text-flux-violet">(paiement initial)</span>@endif</span>
                        <span class="font-medium">{{ number_format($loyer->montant,0,',',' ') }} F — {{ $loyer->statut === 'paye' ? 'Payé' : 'Non payé' }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <aside class="space-y-6">
        <div class="bg-white border border-black/10 rounded-2xl p-6">
            <h3 class="font-medium mb-3">Locataire</h3>
            <p class="text-sm">{{ $baye->client->nom }} — {{ $baye->client->email }}</p>
        </div>
        <div class="bg-white border border-black/10 rounded-2xl p-6">
            <h3 class="font-medium mb-3">Bailleur</h3>
            <p class="text-sm">{{ $baye->bailleur->nom }} — {{ $baye->bailleur->email }}</p>
        </div>
    </aside>
</div>
@endsection
