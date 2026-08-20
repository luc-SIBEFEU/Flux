@extends('layouts.dashboard')
@php $espaceRole = 'bailleur';@endphp
@section('titre_page', 'Mes logements')
@section('titre', 'Mes logements — Bailleur')

@section('contenu')

<div class="flex items-center justify-between mb-6 flex-wrap gap-3">
    <p class="text-sm text-flux-noir/50">{{ $logements->total() }} logement(s)</p>
    <div class="flex gap-3 flex-wrap">
        <form method="GET" class="flex gap-2">
            <select name="type" onchange="this.form.submit()" class="border border-black/10 rounded-lg px-3 py-2.5 text-sm bg-white">
                <option value="">Tous les types</option>
                @foreach(['chambre'=>'Chambre','studio'=>'Studio','appartement'=>'Appartement','villa'=>'Villa'] as $val=>$label)
                    <option value="{{ $val }}" {{ request('type')==$val?'selected':'' }}>{{ $label }}</option>
                @endforeach
            </select>
            <select name="validation" onchange="this.form.submit()" class="border border-black/10 rounded-lg px-3 py-2.5 text-sm bg-white">
                <option value="">Toute validation</option>
                <option value="en_attente" {{ request('validation')=='en_attente'?'selected':'' }}>En attente</option>
                <option value="valide" {{ request('validation')=='valide'?'selected':'' }}>Validés</option>
                <option value="rejete" {{ request('validation')=='rejete'?'selected':'' }}>Rejetés</option>
            </select>
            <select name="statut" onchange="this.form.submit()" class="border border-black/10 rounded-lg px-3 py-2.5 text-sm bg-white">
                <option value="">Toute disponibilité</option>
                <option value="disponible" {{ request('statut')=='disponible'?'selected':'' }}>Disponible</option>
                <option value="loue" {{ request('statut')=='loue'?'selected':'' }}>Loué</option>
            </select>
        </form>
        <a href="{{ route('bailleur.logements.create') }}" class="inline-flex items-center gap-2 bg-flux-violet text-white text-sm font-medium px-4 py-2.5 rounded-lg">
            <x-icon name="plus" class="w-4 h-4" /> Ajouter un logement
        </a>
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
    @foreach($logements as $logement)
        <div class="bg-white border border-black/10 rounded-2xl overflow-hidden">
            <div class="relative">
                @if($logement->photos->first())
                    <img src="{{ asset('storage/'.$logement->photos->first()->chemin) }}" class="w-full h-36 object-cover">
                @else
                    <div class="w-full h-36 bg-flux-violet-pale flex items-center justify-center">
                        <x-icon name="building" class="w-8 h-8 text-flux-violet/40" />
                    </div>
                @endif
                <span class="absolute top-3 left-3 text-xs font-semibold px-2.5 py-1 rounded-full {{ $logement->statut === 'disponible' ? 'bg-flux-violet text-white' : 'bg-black/60 text-white' }}">
                    {{ $logement->statut === 'disponible' ? 'Disponible' : 'Loué' }}
                </span>
                @if($logement->validation !== 'valide')
                    @php $vBadges = ['en_attente'=>'bg-flux-or text-flux-noir','rejete'=>'bg-red-500 text-white']; @endphp
                    <span class="absolute top-3 right-3 text-xs font-semibold px-2.5 py-1 rounded-full {{ $vBadges[$logement->validation] }}">
                        {{ $logement->validation === 'en_attente' ? 'En attente' : 'Rejeté' }}
                    </span>
                @endif
            </div>
            <div class="p-5">
                <h3 class="font-medium capitalize">{{ $logement->type }} @if($logement->minicite) · {{ $logement->minicite->nom }} @endif</h3>
                <p class="text-sm text-flux-noir/50 flex items-center gap-1 mt-1"><x-icon name="map-pin" class="w-3.5 h-3.5" /> {{ $logement->quartier }}, {{ $logement->ville }}</p>
                <p class="font-display text-lg text-flux-violet mt-2">{{ number_format($logement->prix_mois,0,',',' ') }} F<span class="text-xs font-sans text-flux-noir/40">/mois</span></p>

                <div class="flex flex-wrap gap-3 mt-4">
                    <a href="{{ route('bailleur.logements.edit', $logement) }}" class="inline-flex items-center gap-1.5 text-sm text-flux-violet font-medium">
                        <x-icon name="pencil" class="w-4 h-4" /> Modifier
                    </a>
                    <a href="{{ route('bailleur.logements.clients', $logement) }}" class="inline-flex items-center gap-1.5 text-sm text-flux-noir/70 font-medium">
                        <x-icon name="users" class="w-4 h-4" /> Locataires
                    </a>
                    <form action="{{ route('bailleur.logements.destroy', $logement) }}" method="POST" onsubmit="return confirm('Supprimer ce logement ?')">
                        @csrf @method('DELETE')
                        <button class="inline-flex items-center gap-1.5 text-sm text-red-500 font-medium">
                            <x-icon name="trash" class="w-4 h-4" /> Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="mt-8">{{ $logements->links() }}</div>
@endsection
