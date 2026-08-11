@extends('layouts.app')
@section('titre', 'Flux — Réservez un hôtel ou trouvez un logement')

@section('contenu')

<!-- Hero + carrousel d'actualités -->
<section class="relative bg-flux-bleu overflow-hidden">
    <div class="absolute inset-0 opacity-20" style="background:radial-gradient(circle at 80% 20%, var(--color-flux-or), transparent 40%)"></div>

    @if($actualites->isNotEmpty())
        <!-- Carrousel d'actualités en fond du hero -->
        <div class="absolute inset-0" x-data="heroCarousel({{ $actualites->count() }})" x-init="demarrer()">
            @foreach($actualites as $i => $actu)
                <div x-show="index === {{ $i }}" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="absolute inset-0">
                    <img src="{{ asset('storage/'.$actu->image) }}" class="w-full h-full object-cover opacity-25">
                    <div class="absolute inset-0 bg-gradient-to-t from-flux-bleu via-flux-bleu/70 to-flux-bleu/40"></div>
                </div>
            @endforeach

            <!-- Contenu texte de l'actualité active -->
            <div class="absolute bottom-70 sm:bottom-70 left-300 right-4 sm:left-300 sm:right-auto sm:max-w-md">
                <h1>Actualités</h1>
                @foreach($actualites as $i => $actu)
                    <div x-show="index === {{ $i }}" x-transition:enter="transition ease-out duration-500 delay-150" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                        <p class="text-flux-or text-xs font-medium uppercase tracking-wide mb-1">{{ $actu->date_debut->format('d M') }} — {{ $actu->date_fin->format('d M Y') }}</p>
                        <h3 class="font-display text-xl text-white">{{ $actu->nom }}</h3>
                        <p class="text-white/70 text-sm mt-1 line-clamp-2 max-w-sm">{{ $actu->description }}</p>
                    </div>
                @endforeach

                <!-- Puces de navigation -->
                <div class="flex gap-1.5 mt-4">
                    @foreach($actualites as $i => $actu)
                        <button @click="aller({{ $i }})" class="h-1.5 rounded-full transition-all" :class="index === {{ $i }} ? 'w-6 bg-flux-or' : 'w-1.5 bg-white/40'"></button>
                    @endforeach
                </div>
            </div>

            <!-- Flèches -->
            <button @click="precedent()" class="hidden sm:flex absolute left-4 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 items-center justify-center text-white">
                <x-icon name="chevron-down" class="w-4 h-4 rotate-90" />
            </button>
            <button @click="suivant()" class="hidden sm:flex absolute right-4 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 items-center justify-center text-white">
                <x-icon name="chevron-down" class="w-4 h-4 -rotate-90" />
            </button>
        </div>
    @endif

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-28 sm:pt-24 sm:pb-36">
        <p class="text-flux-or text-sm font-medium tracking-widest uppercase mb-3">Hôtels & logements</p>
        <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl text-white max-w-2xl leading-[1.05]">
            Votre séjour, du premier clic au dernier jour.
        </h1>
        <p class="text-white/70 mt-4 max-w-lg">Réservez une chambre d'hôtel ou trouvez le logement à louer qui vous correspond, partout au pays.</p>
    </div>

    <!-- Carte de recherche flottante -->
    <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 sm:-mt-20">
        <form action="{{ route('hotels.index') }}" class="bg-white rounded-2xl shadow-xl p-5 sm:p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            <div class="lg:col-span-2">
                <label class="text-xs font-medium text-flux-noir/50">Destination</label>
                <div class="flex items-center gap-2 mt-1 border border-black/10 rounded-lg px-3 py-2.5">
                    <x-icon name="map-pin" class="w-4 h-4 text-flux-bleu shrink-0" />
                    <input type="text" name="destination" placeholder="Ville, quartier..." class="w-full outline-none text-sm">
                </div>
            </div>
            <div>
                <label class="text-xs font-medium text-flux-noir/50">Arrivée</label>
                <div class="flex items-center gap-2 mt-1 border border-black/10 rounded-lg px-3 py-2.5">
                    <x-icon name="calendar" class="w-4 h-4 text-flux-bleu shrink-0" />
                    <input type="date" name="date_arrivee" class="w-full outline-none text-sm">
                </div>
            </div>
            <div>
                <label class="text-xs font-medium text-flux-noir/50">Départ</label>
                <div class="flex items-center gap-2 mt-1 border border-black/10 rounded-lg px-3 py-2.5">
                    <x-icon name="calendar" class="w-4 h-4 text-flux-bleu shrink-0" />
                    <input type="date" name="date_depart" class="w-full outline-none text-sm">
                </div>
            </div>
            <div class="flex gap-2">
                <div class="flex-1">
                    <label class="text-xs font-medium text-flux-noir/50">Adultes</label>
                    <div class="flex items-center gap-2 mt-1 border border-black/10 rounded-lg px-3 py-2.5">
                        <x-icon name="users" class="w-4 h-4 text-flux-bleu shrink-0" />
                        <input type="number" min="1" value="2" name="adultes" class="w-full outline-none text-sm">
                    </div>
                </div>
                <div class="flex-1">
                    <label class="text-xs font-medium text-flux-noir/50">Enfants</label>
                    <div class="mt-1 border border-black/10 rounded-lg px-3 py-2.5">
                        <input type="number" min="0" value="0" name="enfants" class="w-full outline-none text-sm">
                    </div>
                </div>
            </div>
            <button type="submit" class="lg:col-span-5 mt-1 inline-flex items-center justify-center gap-2 bg-flux-or hover:bg-flux-or-vif text-flux-noir font-semibold py-3 rounded-lg transition-colors">
                <x-icon name="search" class="w-5 h-5" /> Rechercher un hôtel
            </button>
        </form>
    </div>
</section>

<!-- Hôtels en vogue -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-24 mb-24">
    <div class="flex items-end justify-between mb-6">
        <div>
            <p class="text-flux-or text-sm font-medium uppercase tracking-wide">Tendance</p>
            <h2 class="font-display text-2xl sm:text-3xl text-flux-noir">Hôtels en vogue</h2>
        </div>
        <a href="{{ route('hotels.index') }}" class="text-sm font-medium text-flux-bleu hover:underline hidden sm:block">Tout voir →</a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        @foreach($hotelsEnVogue as $hotel)
            <a href="{{ route('hotels.show', $hotel) }}" class="group bg-white rounded-2xl overflow-hidden shadow-sm border border-black/5 hover:shadow-lg transition-shadow">
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
                    <div class="flex items-center gap-0.5 mt-2">
                        @for($i=0; $i<$hotel->nombre_etoiles; $i++)
                            <x-icon name="star-filled" class="w-3.5 h-3.5 text-flux-or" />
                        @endfor
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</section>

@endsection

@push('scripts')
<script>
function heroCarousel(total) {
    return {
        index: 0,
        total: total,
        interval: null,
        demarrer() {
            if (this.total <= 1) return;
            this.interval = setInterval(() => this.suivant(), 6000);
        },
        suivant() { this.index = (this.index + 1) % this.total; },
        precedent() { this.index = (this.index - 1 + this.total) % this.total; },
        aller(i) {
            this.index = i;
            clearInterval(this.interval);
            this.demarrer();
        }
    }
}
</script>
@endpush
