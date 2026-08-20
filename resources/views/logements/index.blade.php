@extends('layouts.app')
@section('titre', 'Logements — Flux')

@section('contenu')
<section class="relative bg-flux-bleu overflow-hidden">
    <div class="absolute inset-0 opacity-20" style="background:radial-gradient(circle at 80% 20%, var(--color-flux-or), transparent 40%)"></div>


    <!-- <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-28 sm:pt-24 sm:pb-36">
        <p class="text-flux-or text-sm font-medium tracking-widest uppercase mb-3">Hôtels</p>
        <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl text-white max-w-2xl leading-[1.05]">
            Votre séjour, du premier clic au dernier jour.
        </h1>
        <p class="text-white/70 mt-4 max-w-lg">Réservez une chambre d'hôtel ou trouvez le logement à louer qui vous correspond, partout au pays.</p>
    </div> -->
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-28 sm:pt-24 sm:pb-36">
        <p class="text-flux-or text-sm font-medium tracking-widest uppercase mb-3">Logements</p>
        <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl text-white max-w-2xl leading-[1.05]">Trouvez votre prochain chez-vous</h1>
        <p class="text-white/70 mt-4 max-w-lg">Trouvez un domicile qui correspond à vos besoins et préferences, partout au pays.</p>
    </div>

    <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 sm:-mt-20">

            <form method="GET" class="bg-white rounded-2xl shadow-xl p-5 sm:p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
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
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-24 mb-24">
        <div class="lg:col-span-3">
            <p class="text-sm text-flux-noir/50 mb-4">{{ $logements->total() }} logement(s) disponible(s)</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">
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
</section>
@endsection
