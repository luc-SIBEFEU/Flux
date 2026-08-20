@extends('layouts.dashboard')
@php($espaceRole = 'admin')
@section('titre_page', $actualite->exists ? 'Modifier l\'actualité' : 'Nouvelle actualité')
@section('titre', 'Actualité — Admin')

@section('contenu')
<div class="mb-7">
<a href="{{ route('admin.actualites.index') }}" class="inline-flex items-center gap-2 text-sm text-flux-bleu font-medium">
    Actualités</a> > {{ $actualite->exists ? 'modifier' : 'Nouvelle actualité' }}</h2>
</div>
<form action="{{ $actualite->exists ? route('admin.actualites.update', $actualite) : route('admin.actualites.store') }}"
      method="POST" enctype="multipart/form-data" class="bg-white border border-black/10 rounded-2xl p-6 max-w-2xl space-y-5">
    @csrf
    @if($actualite->exists) @method('PUT') @endif

    <div>
        <label class="text-xs font-medium text-flux-noir/50">Nom</label>
        <input type="text" name="nom" required value="{{ old('nom', $actualite->nom) }}"
               class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
    </div>

    <div>
        <label class="text-xs font-medium text-flux-noir/50">Description</label>
        <textarea name="description" rows="4" required
                  class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">{{ old('description', $actualite->description) }}</textarea>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="text-xs font-medium text-flux-noir/50">Date de début</label>
            <input type="date" name="date_debut" required value="{{ old('date_debut', optional($actualite->date_debut)->format('Y-m-d')) }}"
                   class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
        </div>
        <div>
            <label class="text-xs font-medium text-flux-noir/50">Date de fin</label>
            <input type="date" name="date_fin" required value="{{ old('date_fin', optional($actualite->date_fin)->format('Y-m-d')) }}"
                   class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
        </div>
    </div>

    <div>
        <label class="text-xs font-medium text-flux-noir/50">Ordre dans le carrousel de l'accueil</label>
        <input type="number" name="ordre" min="0" value="{{ old('ordre', $actualite->ordre ?? 0) }}"
               class="mt-1 w-32 border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
        <p class="text-xs text-flux-noir/40 mt-1">Les actualités s'affichent par ordre croissant (0 en premier).</p>
    </div>

    <div>
        <label class="text-xs font-medium text-flux-noir/50">Image</label>
        @if($actualite->image)
            <img src="{{ asset('storage/'.$actualite->image) }}" class="w-32 h-20 object-cover rounded-lg mt-2 mb-2">
        @endif
        <input type="file" name="image" accept="image/*" class="mt-1 w-full text-sm">
    </div>

    <button type="submit" class="inline-flex items-center gap-2 bg-flux-bleu text-white font-semibold px-6 py-3 rounded-lg">
        {{ $actualite->exists ? 'Enregistrer' : 'Publier' }}
    </button>
</form>
@endsection
