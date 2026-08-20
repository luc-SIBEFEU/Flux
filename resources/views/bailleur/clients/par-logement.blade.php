@extends('layouts.dashboard')
@php $espaceRole = 'bailleur'; @endphp
@section('titre_page', 'Locataires')
@section('titre', 'Locataires — Bailleur')

@section('contenu')

<a href="{{ route('bailleur.logements.index') }}" class="text-sm text-flux-noir/50 hover:text-flux-violet">← Retour aux logements</a>

<div class="bg-white border border-black/10 rounded-2xl p-5 my-6 flex items-center gap-4">
    <div class="w-14 h-14 rounded-xl bg-flux-violet-pale flex items-center justify-center shrink-0">
        <x-icon name="building" class="w-6 h-6 text-flux-violet" />
    </div>
    <div>
        <h2 class="font-medium capitalize">{{ $logement->type }} — {{ $logement->quartier }}, {{ $logement->ville }}</h2>
        <p class="text-sm text-flux-noir/50">{{ number_format($logement->prix_mois,0,',',' ') }} FCFA / mois</p>
    </div>
</div>

<div class="space-y-4">
    @forelse($baux as $bail)
        <div class="bg-white border border-black/10 rounded-2xl p-5 flex items-center justify-between">
            <div>
                <h3 class="font-medium">{{ $bail->client->nom }}</h3>
                <p class="text-sm text-flux-noir/50">{{ $bail->client->telephone }} · {{ $bail->client->email }}</p>
                <p class="text-xs text-flux-noir/40 mt-1">{{ $bail->date_debut->format('d/m/Y') }} → {{ $bail->date_fin_prevue->format('d/m/Y') }}</p>
            </div>
            @php $badges = ['nouveau'=>'bg-flux-or/20 text-flux-or','en_cours'=>'bg-flux-violet-pale text-flux-violet','termine'=>'bg-black/5 text-flux-noir/50']; @endphp
            <span class="text-xs px-2.5 py-1 rounded-full font-medium {{ $badges[$bail->statut] }}">{{ ucfirst(str_replace('_',' ',$bail->statut)) }}</span>
        </div>
    @empty
        <div class="text-center py-16 text-flux-noir/40">
            <x-icon name="users" class="w-10 h-10 mx-auto mb-3" />
            Aucun locataire pour ce logement.
        </div>
    @endforelse
</div>
@endsection
