@extends('layouts.dashboard')
@php($espaceRole = 'bailleur')
@section('titre_page', $logement->exists ? 'Modifier le logement' : 'Nouveau logement')
@section('titre', 'Logement — Bailleur')

@section('contenu')

<form action="{{ $logement->exists ? route('bailleur.logements.update', $logement) : route('bailleur.logements.store') }}"
      method="POST" x-data="{ type: '{{ old('type', $logement->type ?? 'chambre') }}' }" class="bg-white border border-black/10 rounded-2xl p-6 max-w-2xl space-y-5">
    @csrf
    @if($logement->exists) @method('PUT') @endif

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="text-xs font-medium text-flux-noir/50">Type</label>
            <select name="type" x-model="type" class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none">
                @foreach(['chambre'=>'Chambre','studio'=>'Studio','appartement'=>'Appartement','villa'=>'Villa'] as $val=>$label)
                    <option value="{{ $val }}" {{ old('type',$logement->type)==$val?'selected':'' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="text-xs font-medium text-flux-noir/50">Catégorie</label>
            <select name="categorie" class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none" :class="type === 'villa' && 'bg-flux-brume text-flux-noir/40'">
                <option value="standard" {{ old('categorie',$logement->categorie)=='standard'?'selected':'' }}>Standard</option>
                <option value="meuble" {{ old('categorie',$logement->categorie)=='meuble'?'selected':'' }}>Meublé</option>
            </select>
            <p class="text-xs text-flux-violet mt-1" x-show="type === 'villa'">Une villa est toujours meublée (appliqué automatiquement).</p>
        </div>
    </div>

    <div>
        <label class="text-xs font-medium text-flux-noir/50">Mini-cité (optionnel)</label>
        <select name="minicite_id" class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none">
            <option value="">Aucune — logement indépendant</option>
            @foreach($minicites as $mc)
                <option value="{{ $mc->id }}" {{ old('minicite_id',$logement->minicite_id)==$mc->id?'selected':'' }}>{{ $mc->nom }}</option>
            @endforeach
        </select>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="text-xs font-medium text-flux-noir/50">Ville</label>
            <input type="text" name="ville" required value="{{ old('ville', $logement->ville) }}"
                   class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-violet">
        </div>
        <div>
            <label class="text-xs font-medium text-flux-noir/50">Quartier</label>
            <input type="text" name="quartier" required value="{{ old('quartier', $logement->quartier) }}"
                   class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-violet">
        </div>
    </div>

    <div>
        <label class="text-xs font-medium text-flux-noir/50">Lien Google Maps</label>
        <input type="url" name="google_map_lien" value="{{ old('google_map_lien', $logement->google_map_lien) }}"
               class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-violet">
    </div>

    <div class="grid grid-cols-3 gap-4">
        <div>
            <label class="text-xs font-medium text-flux-noir/50">Prix / mois</label>
            <input type="number" name="prix_mois" required value="{{ old('prix_mois', $logement->prix_mois) }}"
                   class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-violet">
        </div>
        <div>
            <label class="text-xs font-medium text-flux-noir/50">Caution</label>
            <input type="number" name="caution" value="{{ old('caution', $logement->caution) }}"
                   class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-violet">
        </div>
        <div>
            <label class="text-xs font-medium text-flux-noir/50">Durée min. (mois)</label>
            <input type="number" name="duree_min_mois" required value="{{ old('duree_min_mois', $logement->duree_min_mois ?? 1) }}"
                   class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-violet">
        </div>
    </div>

    <div>
        <label class="text-xs font-medium text-flux-noir/50 flex items-center gap-1.5">
            Moratoire après fin de bail (jours)
        </label>
        <input type="number" name="moratoire_jours" min="0" max="90" value="{{ old('moratoire_jours', $logement->moratoire_jours ?? 7) }}"
               class="mt-1 w-32 border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-violet">
        <p class="text-xs text-flux-noir/40 mt-1">Délai après la fin du bail avant remise en ligne automatique du logement (7 jours par défaut).</p>
    </div>

    <div>
        <label class="text-xs font-medium text-flux-noir/50 flex items-center gap-1.5">Équipements</label>
        <div class="flex flex-wrap gap-2 mt-2">
            @foreach($equipements as $eq)
                <label>
                    <input type="checkbox" name="equipements[]" value="{{ $eq->id }}" class="peer sr-only"
                           {{ in_array($eq->id, old('equipements', $logement->equipements->pluck('id')->toArray())) ? 'checked' : '' }}>
                    <span class="text-xs px-3 py-1.5 rounded-full border border-black/10 peer-checked:bg-flux-violet peer-checked:text-white peer-checked:border-flux-violet cursor-pointer">{{ $eq->nom }}</span>
                </label>
            @endforeach
        </div>
    </div>

    <div>
        <label class="text-xs font-medium text-flux-noir/50">Informations complémentaires</label>
        <textarea name="info" rows="3" class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-violet">{{ old('info', $logement->info) }}</textarea>
    </div>

    @if(!$logement->exists)
        <div class="bg-flux-violet-pale rounded-lg p-4">
            <label class="text-xs font-medium text-flux-violet flex items-center gap-1.5"><x-icon name="building" class="w-4 h-4" /> J'en possède plusieurs identiques</label>
            <input type="number" name="nombre_exemplaires" min="1" max="50" value="1"
                   class="mt-2 w-32 border border-black/10 rounded-lg px-3 py-2 text-sm outline-none">
            <p class="text-xs text-flux-noir/50 mt-2">Le site créera automatiquement ce nombre de logements identiques, avec un identifiant différent pour chacun.</p>
        </div>
    @endif

    <button type="submit" class="inline-flex items-center gap-2 bg-flux-violet text-white font-semibold px-6 py-3 rounded-lg">
        {{ $logement->exists ? 'Enregistrer' : 'Créer le logement' }}
    </button>
</form>

@if($logement->exists)
    <div class="max-w-2xl mt-6">
        @include('partials.galerie', [
            'model' => $logement,
            'routeStore' => route('bailleur.photos.store', ['logement', $logement->id]),
            'routeDestroy' => 'bailleur.photos.destroy',
            'accent' => 'violet',
        ])
    </div>
@endif
@endsection
