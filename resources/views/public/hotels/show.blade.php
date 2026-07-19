@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    {{-- EN-TÊTE --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div class="flex items-center gap-4">
            @if($hotel->logoUrl())
                <img src="{{ $hotel->logoUrl() }}" alt="Logo {{ $hotel->nom }}" class="w-16 h-16 rounded-full object-cover border shadow">
            @endif
            <div>
                <div class="flex items-center gap-1 text-amber-500">
                    @for($i = 0; $i < $hotel->nombre_etoiles; $i++) ★ @endfor
                </div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $hotel->nom }}</h1>
                <p class="text-gray-500">📍 {{ $hotel->ville }} @if($hotel->adresse) — {{ $hotel->adresse }} @endif</p>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <div class="text-center bg-violet-700 text-white rounded-xl px-4 py-2">
                <div class="text-xl font-bold">{{ number_format($hotel->note_moyenne, 1) }}/10</div>
                <div class="text-xs opacity-80">{{ $hotel->nombre_avis }} avis</div>
            </div>
            @auth
                @if(auth()->user()->isClient())
                <form method="POST" action="{{ route('hotels.favori', $hotel) }}">
                    @csrf
                    <button type="submit" class="text-2xl {{ $estFavori ? 'text-red-500' : 'text-gray-300' }} hover:scale-110 transition">
                        {{ $estFavori ? '❤️' : '🤍' }}
                    </button>
                </form>
                @endif
            @endauth
        </div>
    </div>

    {{-- GALERIE PHOTO --}}
    <div class="grid grid-cols-4 grid-rows-2 gap-2 h-96 rounded-xl overflow-hidden mb-10">
        <div class="col-span-2 row-span-2">
            <img src="{{ $hotel->imageCouvertureUrl() ?? 'https://placehold.co/800x600?text=Hotel' }}"
                 class="w-full h-full object-cover">
        </div>
        @foreach($hotel->galeries->take(4) as $image)
            <div><img src="{{ $image->imageUrl() }}" class="w-full h-full object-cover"></div>
        @endforeach
    </div>

    @if($hotel->description)
        <p class="text-gray-600 mb-10 max-w-3xl">{{ $hotel->description }}</p>
    @endif

    {{-- LOCALISATION --}}
    @if($hotel->latitude && $hotel->longitude)
    <div class="mb-10">
        <h2 class="text-xl font-bold text-gray-900 mb-3">📍 Localisation</h2>
        <iframe
            class="w-full h-72 rounded-xl border-0"
            src="https://www.google.com/maps?q={{ $hotel->latitude }},{{ $hotel->longitude }}&z=15&output=embed">
        </iframe>
    </div>
    @endif

    {{-- CHAMBRES DISPONIBLES --}}
    <div class="mb-10">
        <h2 class="text-xl font-bold text-gray-900 mb-4">🛏️ Catégories de chambres disponibles</h2>
        <div class="space-y-4">
            @forelse($hotel->roomCategories as $chambre)
                <div class="bg-white rounded-xl shadow border border-gray-100 p-5 flex flex-col md:flex-row gap-5">
                    <img src="{{ $chambre->galeries->first()?->imageUrl() ?? 'https://placehold.co/300x200?text=Chambre' }}"
                         class="w-full md:w-56 h-40 object-cover rounded-lg">

                    <div class="flex-1">
                        <h3 class="font-semibold text-lg text-gray-900">{{ $chambre->nom }}</h3>
                        <p class="text-sm text-gray-500 mb-2">
                            👤 {{ $chambre->capacite_adultes }} adultes · 🧒 {{ $chambre->capacite_enfants }} enfants
                        </p>
                        <div class="flex flex-wrap gap-2 mb-2">
                            @foreach($chambre->amenities as $equip)
                                <span class="text-xs bg-violet-50 text-violet-700 px-2 py-1 rounded-full">{{ $equip->nom }}</span>
                            @endforeach
                        </div>
                        @if($chambre->description)
                            <p class="text-sm text-gray-500">{{ $chambre->description }}</p>
                        @endif
                    </div>

                    <div class="flex flex-col items-end justify-between">
                        <div class="text-right">
                            <div class="text-xl font-bold text-violet-700">{{ number_format($chambre->prix_nuit, 0) }} FCFA</div>
                            <div class="text-xs text-gray-400">/ nuit</div>
                        </div>

                        @auth
                            @if(auth()->user()->isClient())
                                <a href="{{ route('reservations.create', array_merge(['hotel' => $hotel->id, 'chambre' => $chambre->id], $criteres)) }}"
                                   class="mt-3 px-5 py-2 bg-amber-400 hover:bg-amber-500 text-gray-900 font-semibold rounded-lg transition">
                                    Réserver
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="mt-3 px-5 py-2 bg-amber-400 hover:bg-amber-500 text-gray-900 font-semibold rounded-lg transition">
                                Se connecter pour réserver
                            </a>
                        @endauth
                    </div>
                </div>
            @empty
                <p class="text-gray-400">Aucune chambre disponible pour le moment.</p>
            @endforelse
        </div>
    </div>

    {{-- AVIS --}}
    <div>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-gray-900">💬 Avis clients</h2>
            @auth
                @if(auth()->user()->isClient())
                    <a href="{{ route('client.reviews.create', $hotel) }}" class="text-sm text-violet-700 hover:underline">Donner mon avis</a>
                @endif
            @endauth
        </div>
        <div class="space-y-4">
            @forelse($hotel->reviewsApprouves as $avis)
                <div class="bg-white rounded-xl shadow border border-gray-100 p-4">
                    <div class="flex items-center justify-between">
                        <span class="font-semibold text-gray-900">{{ $avis->client->nom }}</span>
                        <span class="text-amber-500 font-bold">{{ $avis->note }}/10</span>
                    </div>
                    @if($avis->commentaire)
                        <p class="text-gray-600 text-sm mt-1">{{ $avis->commentaire }}</p>
                    @endif
                </div>
            @empty
                <p class="text-gray-400">Aucun avis pour le moment.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
