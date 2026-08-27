@extends('layouts.app')
@section('titre', $hotel->nom . ' — Flux')

@section('contenu')
<link rel="stylesheet" href="{{ asset('icons/bootstrap-icons.css') }}">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <!-- En-tête -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
        <div>
            <div class="text-sm text-flux-noir/50"><a class="hover:text-flux-violet" href="{{ route('hotels.index') }}">Hotels</a> > <a href="#">{{ $hotel->nom }}</a></div>
            <div class="flex items-center gap-2">
                @for($i=0; $i<$hotel->nombre_etoiles; $i++)<x-icon name="star-filled" class="w-4 h-4 text-flux-or" />@endfor
            </div>
            <h1 class="font-display text-3xl sm:text-4xl text-flux-noir mt-1">{{ $hotel->nom }}</h1>
            <p class="text-flux-noir/50 flex items-center gap-1 mt-1"><x-icon name="map-pin" class="w-4 h-4" /> {{ $hotel->ville }}@if($hotel->adresse), {{ $hotel->adresse }}@endif</p>
        </div>
        @auth
            <form action="{{ route('favoris.toggle', $hotel) }}" method="POST">
                @csrf
                <button class="inline-flex items-center gap-2 px-4 py-2.5 rounded-full border border-black/10 hover:border-flux-violet text-sm font-medium">
                    <x-icon name="heart" class="w-4 h-4 text-flux-violet" /> Ajouter aux favoris
                </button>
            </form>
        @endauth
    </div>

    <!-- Galerie -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-10 rounded-2xl overflow-hidden">
        <img src="{{ asset('storage/'.$hotel->image_couverture) }}" class="col-span-2 row-span-2 w-full h-full object-cover min-h-[220px]">
        @foreach($hotel->photos->take(4) as $photo)
            <img src="{{ asset('storage/'.$photo->chemin) }}" class="w-full h-full object-cover min-h-[105px]">
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <div class="lg:col-span-2 space-y-10">

            @if($hotel->description)
                <section>
                    <h2 class="font-display text-2xl mb-3">À propos</h2>
                    <p class="text-flux-noir/70 leading-relaxed">{{ $hotel->description }}</p>
                </section>
            @endif

                <div class="flex flex-wrap gap-2 mt-2">
                    @foreach($hotel->equipements as $eq)
                        <span class="text-xs bg-flux-bleu-pale text-flux-bleu px-2.5 py-1 rounded-full"><i class="bi bi-{{ $eq->icone }}"></i> {{ $eq->nom }}</span>
                    @endforeach
                </div>
            <!-- Catégories de chambres -->
            <section>
                <h2 class="font-display text-2xl mb-4">Chambres disponibles</h2>
                <div class="space-y-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-5">
                    @foreach($hotel->categorieChambres as $chambre)
                        <div class="border border-black/10 rounded-2xl p-5 flex flex-col sm:flex-row sm:items-center gap-4">
                            @if($chambre->photos->first())
                                <img src="{{ asset('storage/'.$chambre->photos->first()->chemin) }}" class="w-full sm:w-32 h-24 rounded-xl object-cover shrink-0">
                            @endif
                            <div class="flex-1">
                                <h3 class="font-medium">{{ $chambre->nom }}</h3>
                                <p class="text-sm text-flux-noir/50 flex items-center gap-1 mt-1">
                                    <x-icon name="users" class="w-4 h-4" /> {{ $chambre->capacite_adultes }} adulte(s) · {{ $chambre->capacite_enfants }} enfant(s)
                                </p>
                            </div>
                            <div class="text-right shrink-0">
                                <p class="font-display text-xl text-flux-bleu">{{ number_format($chambre->prix_nuit, 0, ',', ' ') }} FCFA</p>
                                <p class="text-xs text-flux-noir/40 mb-2">/ nuit</p>
                                <a href="{{ route('reservations.create', $chambre) }}"
                                   class="inline-flex items-center gap-2 bg-flux-or hover:bg-flux-or-vif text-flux-noir text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
                                    Réserver
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <!-- Avis -->
            <section>
                <h2 class="font-display text-2xl mb-4">Avis clients</h2>
                <div class="space-y-4">
                    @forelse($hotel->avisApprouves as $avis)
                        <div class="border border-black/10 rounded-2xl p-5">
                            <div class="flex items-center justify-between">
                                <span class="font-medium">{{ $avis->client->nom }}</span>
                                <span class="flex items-center gap-1 text-flux-or font-semibold text-sm"><x-icon name="star-filled" class="w-4 h-4" /> {{ $avis->note }}/10</span>
                            </div>
                            <p class="text-sm text-flux-noir/60 mt-2">{{ $avis->commentaire }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-flux-noir/40">Aucun avis pour le moment.</p>
                    @endforelse
                </div>

                @auth
                    <form action="{{ route('avis.store', $hotel) }}" method="POST" class="mt-6 bg-white border border-black/10 rounded-2xl p-5">
                        @csrf
                        <label class="text-sm font-medium">Laisser un avis</label>
                        <textarea name="commentaire" rows="3" class="w-full mt-2 border border-black/10 rounded-lg px-3 py-2 text-sm outline-none focus:border-flux-bleu" placeholder="Votre expérience..."></textarea>
                            <div class="  text-flux-noir/70  mt-3 text-sm">Note (sur 10)</div>
                        <div class="flex items-center -mt-3 gap-3">
                            <input type="range" name="note" min="0" max="10" class="w-full mt-2 accent-flux-or">
                            <button class="bg-flux-bleu text-white text-sm font-medium px-4 py-2 rounded-lg">Publier</button>
                        </div>
                    </form>
                @endauth
            </section>
        </div>

        <!-- Colonne latérale : localisation + réseaux -->
        <aside class="space-y-6">
            @if($hotel->map)
                <div class="rounded-2xl overflow-hidden border border-black/10 h-56">
                <iframe class="w-full h-full" loading="lazy"
                        src="{{ $hotel->map }}">
            @elseif($hotel->latitude)
                </iframe> 
                    <iframe class="w-full h-full" loading="lazy"
                        src="https://www.google.com/maps?q={{ $hotel->latitude }},{{ $hotel->longitude }}&output=embed"></iframe>
                </div>
            @endif

            @if($hotel->reseauxSociaux->isNotEmpty())
                <div class="bg-white border border-black/10 rounded-2xl p-5">
                    <h3 class="font-medium mb-3">Réseaux sociaux</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($hotel->reseauxSociaux as $rs)
                            <a href="{{ $rs->lien }}" target="_blank" class="bg-flux-brume px-3 py-1.5 rounded-full text-2xl text-flux-noir hover:text-flux-or">
                                @if($rs->plateforme == 'x')
                                    <i class="bi bi-twitter-x"></i></a>
                                @elseif($rs->plateforme == 'site_web')
                                <i class="bi bi-globe"></i></a>
                                @else
                                <i class="bi bi-{{ $rs->plateforme }}"></i>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </aside>
    </div>
</div>
@endsection
