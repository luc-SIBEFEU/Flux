@extends('layouts.dashboard')
@php $espaceRole = 'hotelier'; @endphp
@section('titre_page', $chambre->exists ? __('chambre.modifier_categorie') : __('chambre.nouvelle_categorie'))
@section('titre', __('chambre.chambre_singulier') . ' — ' . __('sidebar.espace_hotelier'))

@section('contenu')

    <p class="mb-5"><a href="{{ route('hotelier.hotels.index') }}" class="text-sm text-flux-noir/50 hover:text-flux-bleu">{{ __('navigation.hotels') }} ></a> <a href="{{ route('hotelier.hotels.chambres.index', $hotel) }}" class="text-sm text-flux-noir/50 hover:text-flux-bleu">{{ $hotel->nom }} ></a> {{ $chambre->nom . ' > ' . __('common.modifier') }}</p>
<form action="{{ $chambre->exists ? route('hotelier.hotels.chambres.update', [$hotel, $chambre]) : route('hotelier.hotels.chambres.store', $hotel) }}"
      method="POST" class="bg-white border border-black/10 rounded-2xl p-6 max-w-2xl space-y-5">
    @csrf
    @if($chambre->exists) @method('PUT') @endif

    <div>
        <label class="text-xs font-medium text-flux-noir/50">{{ __('chambre.nom_categorie') }}</label>
        <input type="text" name="nom" required value="{{ old('nom', $chambre->nom) }}" placeholder="{{ __('chambre.exemple_nom') }}"
               class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="text-xs font-medium text-flux-noir/50">{{ __('chambre.capacite_adultes') }}</label>
            <input type="number" name="capacite_adultes" min="1" required value="{{ old('capacite_adultes', $chambre->capacite_adultes ?? 2) }}"
                   class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
        </div>
        <div>
            <label class="text-xs font-medium text-flux-noir/50">{{ __('chambre.capacite_enfants') }}</label>
            <input type="number" name="capacite_enfants" min="0" value="{{ old('capacite_enfants', $chambre->capacite_enfants ?? 0) }}"
                   class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="text-xs font-medium text-flux-noir/50">{{ __('chambre.prix_nuit') }}</label>
            <input type="number" name="prix_nuit" required value="{{ old('prix_nuit', $chambre->prix_nuit) }}"
                   class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
        </div>
        <div>
            <label class="text-xs font-medium text-flux-noir/50">{{ __('chambre.nombre_disponible') }}</label>
            <input type="number" name="nombre_disponible" min="1" required value="{{ old('nombre_disponible', $chambre->nombre_disponible ?? 1) }}"
                   class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
        </div>
    </div>

    <div>
        <label class="text-xs font-medium text-flux-noir/50">{{ __('common.description') }}</label>
        <textarea name="description" rows="3" class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">{{ old('description', $chambre->description) }}</textarea>
    </div>

    <button type="submit" class="inline-flex items-center gap-2 bg-flux-bleu text-white font-semibold px-6 py-3 rounded-lg">
        {{ $chambre->exists ? __('form.enregistrer') : __('chambre.creer_categorie') }}
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
