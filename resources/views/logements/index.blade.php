@extends('layouts.app')
@section('titre', 'Logements — Flux')

@section('contenu')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="mb-8">
        <p class="text-flux-violet text-sm font-medium uppercase tracking-wide">Logements</p>
        <h1 class="font-display text-3xl sm:text-4xl text-flux-noir">Trouvez votre prochain chez-vous</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

        <aside class="lg:col-span-1">
            <form method="GET" class="bg-white rounded-2xl border border-black/5 p-5 space-y-5 lg:sticky lg:top-24">
                <div class="flex items-center gap-2 text-flux-noir font-medium">
                    <x-icon name="filter" class="w-4 h-4 text-flux-violet" /> Filtrer
                </div>

                <div>
                    <label class="text-xs font-medium text-flux-noir/50">Ville / quartier</label>
                    <input type="text" name="ville" value="{{ request('ville') }}"
                           class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2 text-sm outline-none focus:border-flux-violet">
                </div>

                <div>
                    <label class="text-xs font-medium text-flux-noir/50">Type</label>
                    <select name="type" class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2 text-sm outline-none">
                        <option value="">Tous</option>
                        @foreach(['chambre'=>'Chambre','studio'=>'Studio','appartement'=>'Appartement','villa'=>'Villa'] as $val=>$label)
                            <option value="{{ $val }}" {{ request('type')==$val?'selected':'' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="text-xs font-medium text-flux-noir/50">Catégorie</label>
                    <div class="flex gap-2 mt-2">
                        @foreach(['standard'=>'Standard','meuble'=>'Meublé'] as $val=>$label)
                            <label class="flex-1">
                                <input type="radio" name="categorie" value="{{ $val }}" class="peer sr-only" {{ request('categorie')==$val?'checked':'' }}>
                                <div class="text-center text-xs py-2 rounded-lg border border-black/10 peer-checked:bg-flux-violet peer-checked:text-white peer-checked:border-flux-violet cursor-pointer">{{ $label }}</div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <label class="text-xs font-medium text-flux-noir/50">Prix max / mois</label>
                    <input type="number" name="prix_max" value="{{ request('prix_max') }}" placeholder="FCFA"
                           class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2 text-sm outline-none focus:border-flux-violet">
                </div>

                <button type="submit" class="w-full bg-flux-violet hover:bg-flux-violet-vif text-white text-sm font-medium py-2.5 rounded-lg transition-colors">
                    Appliquer les filtres
                </button>
            </form>
        </aside>

        <div class="lg:col-span-3">
            <p class="text-sm text-flux-noir/50 mb-4">{{ $logements->total() }} logement(s) disponible(s)</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
                @forelse($logements as $logement)
                    <a href="{{ route('logements.show', $logement) }}" class="group bg-white rounded-2xl overflow-hidden shadow-sm border border-black/5 hover:shadow-lg transition-shadow">
                        <div class="relative">
                            @if($logement->photos->first())
                                <img src="{{ asset('storage/'.$logement->photos->first()->chemin) }}" class="w-full h-44 object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-44 bg-flux-violet-pale flex items-center justify-center">
                                    <x-icon name="building" class="w-10 h-10 text-flux-violet/40" />
                                </div>
                            @endif
                            <span class="absolute top-3 left-3 bg-white/90 backdrop-blur px-2.5 py-1 rounded-full text-xs font-semibold capitalize">{{ $logement->type }}</span>
                        </div>
                        <div class="p-4">
                            <h3 class="font-medium text-flux-noir">{{ ucfirst($logement->type) }} {{ $logement->categorie === 'meuble' ? 'meublé' : 'standard' }}</h3>
                            <p class="text-sm text-flux-noir/50 flex items-center gap-1 mt-1">
                                <x-icon name="map-pin" class="w-3.5 h-3.5" /> {{ $logement->quartier }}, {{ $logement->ville }}
                            </p>
                            <p class="font-display text-lg text-flux-violet mt-2">{{ number_format($logement->prix_mois, 0, ',', ' ') }} FCFA <span class="text-xs text-flux-noir/40 font-sans">/ mois</span></p>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-16 text-flux-noir/40">
                        <x-icon name="search" class="w-10 h-10 mx-auto mb-3" />
                        Aucun logement ne correspond à ces critères.
                    </div>
                @endforelse
            </div>

            <div class="mt-8">{{ $logements->links() }}</div>
        </div>
    </div>
</div>
@endsection
