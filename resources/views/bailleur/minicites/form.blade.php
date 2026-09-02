@extends('layouts.dashboard')
@php($espaceRole = 'bailleur')
@section('titre_page', $minicite->exists ? 'Modifier la mini-cité' : 'Nouvelle mini-cité')
@section('titre', 'Mini-cité — Bailleur')

@section('contenu')

<form action="{{ $minicite->exists ? route('bailleur.minicites.update', $minicite) : route('bailleur.minicites.store') }}"
      method="POST" class="bg-white border border-black/10 rounded-2xl p-6 max-w-2xl space-y-5">
    @csrf
    @if($minicite->exists) @method('PUT') @endif

    <div>
        <label class="text-xs font-medium text-flux-noir/50">Nom de la mini-cité</label>
        <input type="text" name="nom" required value="{{ old('nom', $minicite->nom) }}"
               class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-violet">
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="text-xs font-medium text-flux-noir/50">{{ __('common.ville') }}</label>
            <input type="text" name="ville" required value="{{ old('ville', $minicite->ville) }}"
                   class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-violet">
        </div>
        <div>
            <label class="text-xs font-medium text-flux-noir/50">Quartier</label>
            <input type="text" name="quartier" required value="{{ old('quartier', $minicite->quartier) }}"
                   class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-violet">
        </div>
    </div>

    <div>
        <label class="text-xs font-medium text-flux-noir/50">Lien Google Maps</label>
        <input type="url" name="google_map_lien" value="{{ old('google_map_lien', $minicite->google_map_lien) }}"
               class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-violet">
    </div>

    <div>
        <label class="text-xs font-medium text-flux-noir/50">Informations complémentaires</label>
        <textarea name="info" rows="3" class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-violet">{{ old('info', $minicite->info) }}</textarea>
    </div>

    <button type="submit" class="inline-flex items-center gap-2 bg-flux-violet text-white font-semibold px-6 py-3 rounded-lg">
        {{ $minicite->exists ? __('form.enregistrer') : __('minicite.creer_minicite') }}
    </button>
</form>

@if($minicite->exists)
    <div class="max-w-2xl mt-6">
        @include('partials.galerie', [
            'model' => $minicite,
            'routeStore' => route('bailleur.photos.store', ['minicite', $minicite->id]),
            'routeDestroy' => 'bailleur.photos.destroy',
            'accent' => 'violet',
        ])
    </div>
@endif
@endsection
