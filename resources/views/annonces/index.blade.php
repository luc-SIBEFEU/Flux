@extends('layouts.app')
@section('titre', __('navigation.annonces') . ' — Flux')

@section('contenu')
<section class="relative bg-flux-bleu overflow-hidden">
    <div class="absolute inset-0 opacity-20" style="background:radial-gradient(circle at 80% 20%, var(--color-flux-or), transparent 40%)"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-28 sm:pt-24 sm:pb-36">
        <p class="text-flux-or text-sm font-medium tracking-widest uppercase mb-3">{{ __('navigation.annonces') }}</p>
        <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl text-white max-w-2xl leading-[1.05]">{{ __('annonces_page.hero_titre') }}</h1>
        <p class="text-white/70 mt-4 max-w-lg">{{ __('annonces_page.hero_desc') }}</p>
    </div>

    <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 sm:-mt-20">

        <x-search-tabs actif="annonces" />

        <form method="GET" class="bg-white rounded-2xl rounded-tl-none shadow-xl p-5 sm:p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4">
            <div class="flex items-center gap-2 text-flux-noir font-medium">
                <x-icon name="filter" class="w-4 h-4 text-flux-or" /> {{ __('common.filtrer') }}
            </div>

            <div>
                <label class="text-xs font-medium text-flux-noir/50">{{ __('common.ville') }}</label>
                <input type="text" name="ville" value="{{ request('ville') }}" list="villes-annonces"
                       class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2 text-sm outline-none focus:border-flux-or">
                <datalist id="villes-annonces">
                    @foreach($villes as $ville)
                        <option value="{{ $ville }}"></option>
                    @endforeach
                </datalist>
            </div>

            <div>
                <label class="text-xs font-medium text-flux-noir/50">{{ __('annonces_page.categorie') }}</label>
                <select name="categorie" class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2 text-sm outline-none bg-white">
                    <option value="">{{ __('common.tout') }}</option>
                    @foreach(['promotion','information','evenement','disponibilite','autre'] as $cat)
                        <option value="{{ $cat }}" {{ request('categorie')==$cat?'selected':'' }}>{{ __('annonces_page.categorie_' . $cat) }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-xs font-medium text-flux-noir/50">{{ __('annonces_page.publie_par') }}</label>
                <select name="role" class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2 text-sm outline-none bg-white">
                    <option value="">{{ __('common.tout') }}</option>
                    <option value="hotelier" {{ request('role')=='hotelier'?'selected':'' }}>{{ __('dashboard_stats.hoteliers') }}</option>
                    <option value="bailleur" {{ request('role')=='bailleur'?'selected':'' }}>{{ __('dashboard_stats.bailleurs') }}</option>
                </select>
            </div>

            <div class="lg:col-span-2">
                <label class="text-xs font-medium text-flux-noir/50">{{ __('common.rechercher') }}</label>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="{{ __('annonces_page.rechercher_placeholder') }}"
                       class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2 text-sm outline-none focus:border-flux-or">
            </div>

            <button type="submit" class="w-full bg-flux-or hover:bg-flux-or-vif text-flux-noir text-sm font-semibold py-2.5 rounded-lg transition-colors self-end">
                {{ __('common.appliquer_filtres') }}
            </button>
        </form>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-24 mb-24">
    <p class="text-sm text-flux-noir/50 mb-4">{{ trans_choice('annonces_page.annonces_compte', $annonces->total(), ['n' => $annonces->total()]) }}</p>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($annonces as $annonce)
            <a href="{{ route('annonces.show', $annonce) }}" class="group bg-white rounded-2xl overflow-hidden shadow-sm border border-black/5 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                <div class="relative">
                    @if($annonce->image)
                        <img src="{{ asset('storage/'.$annonce->image) }}" class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="w-full h-40 bg-flux-or/10 flex items-center justify-center">
                            <x-icon name="megaphone" class="w-10 h-10 text-flux-or/50" />
                        </div>
                    @endif
                    <span class="absolute top-3 left-3 bg-white/90 backdrop-blur px-2.5 py-1 rounded-full text-xs font-semibold">{{ __('annonces_page.categorie_' . $annonce->categorie) }}</span>
                </div>
                <div class="p-4">
                    <h3 class="font-medium text-flux-noir line-clamp-2">{{ $annonce->titre }}</h3>
                    <p class="text-sm text-flux-noir/50 flex items-center gap-1 mt-1">
                        <x-icon name="map-pin" class="w-3.5 h-3.5" /> {{ $annonce->ville }}
                    </p>
                    <p class="text-xs text-flux-noir/40 mt-2 flex items-center gap-1.5">
                        <x-icon name="{{ $annonce->auteur->role === 'hotelier' ? 'building' : 'key' }}" class="w-3.5 h-3.5" />
                        {{ $annonce->auteur->nom }}
                    </p>
                </div>
            </a>
        @empty
            <div class="col-span-full text-center py-16 text-flux-noir/40">
                <x-icon name="search" class="w-10 h-10 mx-auto mb-3" />
                {{ __('annonces_page.aucun_resultat') }}
            </div>
        @endforelse
    </div>

    <div class="mt-8">{{ $annonces->links() }}</div>
</section>
@endsection
