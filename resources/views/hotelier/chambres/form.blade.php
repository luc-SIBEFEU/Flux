@extends('layouts.dashboard')
@php $espaceRole = 'hotelier'; @endphp
@section('titre_page', $chambre->exists ? 'Modifier la catégorie' : 'Nouvelle catégorie de chambre')
@section('titre', 'Chambre — Hôtelier')

@section('contenu')

<form action="{{ $chambre->exists ? route('hotelier.hotels.chambres.update', [$hotel, $chambre]) : route('hotelier.hotels.chambres.store', $hotel) }}"
      method="POST" class="bg-white border border-black/10 rounded-2xl p-6 max-w-2xl space-y-5">
    @csrf
    @if($chambre->exists) @method('PUT') @endif

    <div>
        <label class="text-xs font-medium text-flux-noir/50">Nom de la catégorie</label>
        <input type="text" name="nom" required value="{{ old('nom', $chambre->nom) }}" placeholder="Ex: Chambre Deluxe"
               class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="text-xs font-medium text-flux-noir/50">Capacité adultes</label>
            <input type="number" name="capacite_adultes" min="1" required value="{{ old('capacite_adultes', $chambre->capacite_adultes ?? 2) }}"
                   class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
        </div>
        <div>
            <label class="text-xs font-medium text-flux-noir/50">Capacité enfants</label>
            <input type="number" name="capacite_enfants" min="0" value="{{ old('capacite_enfants', $chambre->capacite_enfants ?? 0) }}"
                   class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="text-xs font-medium text-flux-noir/50">Prix / nuit (FCFA)</label>
            <input type="number" name="prix_nuit" required value="{{ old('prix_nuit', $chambre->prix_nuit) }}"
                   class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
        </div>
        <div>
            <label class="text-xs font-medium text-flux-noir/50">Nombre disponible</label>
            <input type="number" name="nombre_disponible" min="1" required value="{{ old('nombre_disponible', $chambre->nombre_disponible ?? 1) }}"
                   class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
        </div>
    </div>

    <div>
        <label class="text-xs font-medium text-flux-noir/50">Équipements</label>
        <div class="flex flex-wrap gap-2 mt-2">
            @foreach($equipements as $eq)
                <label>
                    <input type="checkbox" name="equipements[]" value="{{ $eq->id }}" class="peer sr-only"
                           {{ in_array($eq->id, old('equipements', $chambre->equipements->pluck('id')->toArray() ?? [])) ? 'checked' : '' }}>
                    <span class="text-xs px-3 py-1.5 rounded-full border border-black/10 peer-checked:bg-flux-bleu peer-checked:text-white peer-checked:border-flux-bleu cursor-pointer">{{ $eq->nom }}</span>
                </label>
            @endforeach
        </div>
    </div>

    <div>
        <label class="text-xs font-medium text-flux-noir/50">Description</label>
        <textarea name="description" rows="3" class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">{{ old('description', $chambre->description) }}</textarea>
    </div>

    <button type="submit" class="inline-flex items-center gap-2 bg-flux-bleu text-white font-semibold px-6 py-3 rounded-lg">
        {{ $chambre->exists ? 'Enregistrer' : 'Créer la catégorie' }}
    </button>
</form>

@if($chambre->exists)
    <div class="max-w-2xl mt-6">
        @include('partials.galerie', [
            'model' => $chambre,
            'routeStore' => route('hotelier.photos.store', ['chambre', $chambre->id]),
            'routeDestroy' => 'hotelier.photos.destroy',
            'accent' => 'bleu',
        ])
    </div>
@endif
@endsection
