@extends('layouts.dashboard')
@php $espaceRole = 'admin'; @endphp
@section('titre_page', 'Forfaits')
@section('titre', 'Forfaits — Admin')

@section('contenu')

<p class="text-sm text-flux-noir/60 mb-6">
    Le forfait free est gratuit et fixe. Vous pouvez modifier le prix, la durée et la description des formules pro ;
    les hôteliers/bailleurs déjà abonnés conservent leur période en cours au tarif souscrit.
</p>

<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
    @foreach ($forfaits as $forfait)
        <div class="bg-white border border-black/10 rounded-2xl p-6">
            <div class="flex items-center justify-between mb-4">
                <span class="font-display text-lg">{{ $forfait->nom }}</span>
                <span class="text-xs px-2.5 py-1 rounded-full font-medium {{ $forfait->type === 'free' ? 'bg-flux-noir/5 text-flux-noir/60' : 'bg-flux-bleu-pale text-flux-bleu' }}">
                    {{ ucfirst($forfait->type) }}
                </span>
            </div>

            @if ($forfait->estFree())
                <p class="text-sm text-flux-noir/60">Gratuit, illimité — ajout d'hôtels/logements sans réservation en ligne.</p>
            @else
                <form method="POST" action="{{ route('admin.forfaits.update', $forfait) }}" class="space-y-3">
                    @csrf @method('PUT')

                    <label class="block text-xs text-flux-noir/50 font-medium">Nom</label>
                    <input type="text" name="nom" value="{{ $forfait->nom }}" class="w-full border border-black/10 rounded-lg px-3 py-2 text-sm">

                    <label class="block text-xs text-flux-noir/50 font-medium">Prix (FCFA)</label>
                    <input type="number" step="0.01" name="prix" value="{{ $forfait->prix }}" class="w-full border border-black/10 rounded-lg px-3 py-2 text-sm">

                    <label class="block text-xs text-flux-noir/50 font-medium">Durée (jours)</label>
                    <input type="number" name="duree_jours" value="{{ $forfait->duree_jours }}" class="w-full border border-black/10 rounded-lg px-3 py-2 text-sm">

                    <label class="block text-xs text-flux-noir/50 font-medium">Description</label>
                    <textarea name="description" rows="3" class="w-full border border-black/10 rounded-lg px-3 py-2 text-sm">{{ $forfait->description }}</textarea>

                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" name="actif" value="1" {{ $forfait->actif ? 'checked' : '' }}>
                        Formule proposée aux hôteliers/bailleurs
                    </label>

                    <button class="w-full px-4 py-2.5 rounded-xl bg-flux-bleu-vif text-white text-sm font-medium">Enregistrer</button>
                </form>
            @endif
        </div>
    @endforeach
</div>
@endsection
