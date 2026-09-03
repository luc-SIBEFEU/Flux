@extends('layouts.app')
@section('titre', __('navigation.hotels') . ' — Flux')

@section('contenu')

<section class="relative bg-flux-bleu overflow-hidden">
    <div class="absolute inset-0 opacity-20" style="background:radial-gradient(circle at 80% 20%, var(--color-flux-or), transparent 40%)"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-28 sm:pt-24 sm:pb-36">
        <p class="text-flux-or text-sm font-medium tracking-widest uppercase mb-3">{{ __('navigation.hotels') }}</p>
        <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl text-white max-w-2xl leading-[1.05]">
            {{ __('hotels_page.hero_titre') }}
        </h1>
        <p class="text-white/70 mt-4 max-w-lg">{{ __('hotels_page.hero_desc') }}</p>
    </div>

    <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 sm:-mt-20">

        <x-search-tabs actif="hotels" />

        <form method="GET" class="bg-white rounded-2xl rounded-tl-none shadow-xl p-5 sm:p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4">
            <div class="flex items-center gap-2 text-flux-noir font-medium">
                <x-icon name="filter" class="w-4 h-4 text-flux-bleu" /> {{ __('common.filtrer') }}
            </div>

            <div>
                <label class="text-xs font-medium text-flux-noir/50">{{ __('hotels_page.destination') }}</label>
                <input type="text" name="destination" value="{{ request('destination') }}" placeholder="{{ __('hotels_page.ville_placeholder') }}"
                       list="villes-hotels"
                       class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2 text-sm outline-none focus:border-flux-bleu">
                <datalist id="villes-hotels">
                    @foreach($villes as $ville)
                        <option value="{{ $ville }}"></option>
                    @endforeach
                </datalist>
            </div>

            <div>
                <label class="text-xs font-medium text-flux-noir/50">{{ __('hotels_page.etoiles_minimum') }}</label>
                <div class="flex gap-2 mt-2">
                    @foreach([1,2,3,4,5] as $n)
                        <label class="flex-1">
                            <input type="radio" name="etoiles" value="{{ $n }}" class="peer sr-only" {{ request('etoiles')==$n ? 'checked' : '' }}>
                            <div class="text-center text-xs py-1.5 rounded-lg border border-black/10 peer-checked:bg-flux-bleu peer-checked:text-white peer-checked:border-flux-bleu cursor-pointer">{{ $n }}★</div>
                        </label>
                    @endforeach
                </div>
            </div>

            <div>
                <label class="text-xs font-medium text-flux-noir/50">{{ __('hotels_page.note_minimum') }}</label>
                <input type="range" min="0" max="10" name="note_min" value="{{ request('note_min', 0) }}" class="w-full mt-2 accent-flux-or">
            </div>

            <div>
                <label class="text-xs font-medium text-flux-noir/50">{{ __('hotels_page.equipement') }}</label>
                <select name="equipement" class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2 text-sm outline-none focus:border-flux-bleu bg-white">
                    <option value="">{{ __('common.tout') }}</option>
                    @foreach($equipements as $eq)
                        <option value="{{ $eq->id }}" {{ request('equipement') == $eq->id ? 'selected' : '' }}>{{ $eq->nom }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-xs font-medium text-flux-noir/50">{{ __('common.trier_par') }}</label>
                <select name="tri" class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2 text-sm outline-none focus:border-flux-bleu bg-white">
                    <option value="note" {{ request('tri', 'note') === 'note' ? 'selected' : '' }}>{{ __('hotels_page.tri_note') }}</option>
                    <option value="etoiles" {{ request('tri') === 'etoiles' ? 'selected' : '' }}>{{ __('hotels_page.tri_etoiles') }}</option>
                    <option value="recent" {{ request('tri') === 'recent' ? 'selected' : '' }}>{{ __('common.tri_recent') }}</option>
                </select>
            </div>

            <button type="submit" class="w-full bg-flux-bleu hover:bg-flux-bleu-vif text-white text-sm font-medium py-2.5 rounded-lg transition-colors self-end">
                {{ __('common.appliquer_filtres') }}
            </button>

        </form>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-24 mb-24">
    <div class="lg:col-span-4">
        <p class="text-2xl text-flux-noir/50 mb-4">{{ trans_choice('hotels_page.hotels_disponibles_compte', $hotels->total(), ['n' => $hotels->total()]) }}</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @forelse($hotels as $hotel)
                <a href="{{ route('hotels.show', $hotel) }}" class="group bg-white rounded-2xl overflow-hidden shadow-sm border border-black/5 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                    <div class="relative">
                        <img src="{{ asset('storage/'.$hotel->image_couverture) }}" alt="{{ $hotel->nom }}" class="w-full h-44 object-cover group-hover:scale-105 transition-transform duration-300">
                        <span class="absolute top-3 left-3 flex items-center gap-1 bg-white/90 backdrop-blur px-2.5 py-1 rounded-full text-xs font-semibold">
                            <x-icon name="star-filled" class="w-3.5 h-3.5 text-flux-or" /> {{ number_format($hotel->note_moyenne, 1) }}
                        </span>
                    </div>
                    <div class="p-4">
                        <h3 class="font-medium text-flux-noir truncate">{{ $hotel->nom }}</h3>
                        <p class="text-sm text-flux-noir/50 flex items-center gap-1 mt-1">
                            <x-icon name="map-pin" class="w-3.5 h-3.5" /> {{ $hotel->ville }}
                        </p>
                            <div class="flex flex-wrap gap-2 mt-2">
                                @foreach($hotel->equipements as $eq)
                                    <span class="text-xs bg-flux-bleu-pale text-flux-bleu px-2.5 py-1 rounded-full"><i class="bi bi-{{ $eq->icone }}"></i> {{ $eq->nom }}</span>
                                @endforeach
                            </div>
                        <div class="flex items-center gap-0.5 mt-2">
                            @for($i=0; $i<$hotel->nombre_etoiles; $i++)
                                <x-icon name="star-filled" class="w-3.5 h-3.5 text-flux-or" />
                            @endfor
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-16 text-flux-noir/40">
                    <x-icon name="search" class="w-10 h-10 mx-auto mb-3" />
                    {{ __('hotels_page.aucun_resultat') }}
                </div>
            @endforelse
        </div>

        <div class="mt-8">{{ $hotels->links() }}</div>
    </div>
</section>
@endsection
