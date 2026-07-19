@extends('layouts.app')

@section('content')
    {{-- HERO + FORMULAIRE DE RECHERCHE --}}
    <section class="relative bg-gradient-to-br from-[#1b0a3f] via-[#3b1585] to-[#0d0620] text-white py-20 px-4">
        <div class="max-w-5xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-3">
                Trouvez l'hôtel <span class="text-amber-400">parfait</span> pour votre séjour
            </h1>
            <p class="text-white/70 mb-10">Des centaines d'hôtels vérifiés, réservables en quelques clics.</p>

            <form method="GET" action="{{ route('hotels.index') }}"
                  class="bg-white rounded-2xl shadow-2xl p-4 md:p-6 grid grid-cols-1 md:grid-cols-6 gap-3 text-left">
                <div class="md:col-span-2">
                    <label class="text-xs font-semibold text-gray-500 uppercase">Destination</label>
                    <input type="text" name="destination" placeholder="Ville, quartier..."
                           class="w-full mt-1 rounded-lg border-gray-300 text-gray-800 focus:ring-violet-600 focus:border-violet-600">
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase">Arrivée</label>
                    <input type="date" name="date_debut" required
                           class="w-full mt-1 rounded-lg border-gray-300 text-gray-800 focus:ring-violet-600 focus:border-violet-600">
                    @error('date_debut') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase">Départ</label>
                    <input type="date" name="date_fin" required
                           class="w-full mt-1 rounded-lg border-gray-300 text-gray-800 focus:ring-violet-600 focus:border-violet-600">
                    @error('date_fin') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase">Adultes</label>
                    <input type="number" min="1" name="adultes" value="1"
                           class="w-full mt-1 rounded-lg border-gray-300 text-gray-800 focus:ring-violet-600 focus:border-violet-600">
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase">Enfants</label>
                    <input type="number" min="0" name="enfants" value="0"
                           class="w-full mt-1 rounded-lg border-gray-300 text-gray-800 focus:ring-violet-600 focus:border-violet-600">
                </div>
                <div class="md:col-span-6">
                    <button type="submit"
                            class="w-full md:w-auto px-8 py-3 bg-violet-700 hover:bg-violet-800 text-white font-semibold rounded-lg transition">
                        🔍 Rechercher
                    </button>
                </div>
            </form>
        </div>
    </section>

    {{-- ACTUALITÉS --}}
    @if($actualites->isNotEmpty())
    <section class="max-w-7xl mx-auto px-4 py-14">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 border-l-4 border-amber-400 pl-3">Actualités</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($actualites as $actualite)
            <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden hover:shadow-lg transition">
                @if($actualite->imageUrl())
                <img src="{{ $actualite->imageUrl() }}" class="w-full h-40 object-cover" alt="{{ $actualite->nom }}">
                @endif
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900">{{ $actualite->nom }}</h3>
                    <p class="text-sm text-gray-500 mt-1 line-clamp-3">{{ $actualite->description }}</p>
                    <p class="text-xs text-violet-700 mt-2 font-medium">
                        Du {{ $actualite->date_debut->format('d/m/Y') }} au {{ $actualite->date_fin->format('d/m/Y') }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- HÔTELS EN VOGUE --}}
    <section class="max-w-7xl mx-auto px-4 py-14">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 border-l-4 border-violet-700 pl-3">Hôtels en vogue</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($hotelsEnVogue as $hotel)
                <x-hotel-card :hotel="$hotel" />
            @endforeach
        </div>
        <div class="text-center mt-8">
            <a href="{{ route('hotels.index') }}"
               class="inline-block px-6 py-3 border-2 border-violet-700 text-violet-700 font-semibold rounded-lg hover:bg-violet-700 hover:text-white transition">
                Voir tous les hôtels
            </a>
        </div>
    </section>
@endsection
