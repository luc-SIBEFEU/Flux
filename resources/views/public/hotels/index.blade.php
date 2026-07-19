@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Nos hôtels</h1>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        {{-- FILTRES --}}
        <aside class="lg:col-span-1 bg-white rounded-xl shadow border border-gray-100 p-5 h-fit sticky top-4">
            <form method="GET" action="{{ route('hotels.index') }}">
                <h2 class="font-semibold text-gray-900 mb-4">🔎 Recherche</h2>
                <div class="space-y-3 mb-5">
                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase">Destination</label>
                        <input type="text" name="destination" value="{{ request('destination') }}"
                               class="w-full mt-1 rounded-lg border-gray-300 text-sm focus:ring-violet-600 focus:border-violet-600">
                    </div>
                    <div class="flex gap-2">
                        <div class="flex-1">
                            <label class="text-xs font-semibold text-gray-500 uppercase">Adultes</label>
                            <input type="number" min="1" name="adultes" value="{{ request('adultes', 1) }}"
                                   class="w-full mt-1 rounded-lg border-gray-300 text-sm focus:ring-violet-600 focus:border-violet-600">
                        </div>
                        <div class="flex-1">
                            <label class="text-xs font-semibold text-gray-500 uppercase">Enfants</label>
                            <input type="number" min="0" name="enfants" value="{{ request('enfants', 0) }}"
                                   class="w-full mt-1 rounded-lg border-gray-300 text-sm focus:ring-violet-600 focus:border-violet-600">
                        </div>
                    </div>
                </div>

                <h2 class="font-semibold text-gray-900 mb-4">⭐ Filtres</h2>
                <div class="space-y-3">
                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase">Nombre d'étoiles minimum</label>
                        <select name="etoiles" class="w-full mt-1 rounded-lg border-gray-300 text-sm focus:ring-violet-600 focus:border-violet-600">
                            <option value="">Toutes</option>
                            @foreach([1,2,3,4,5] as $n)
                                <option value="{{ $n }}" @selected(request('etoiles') == $n)>{{ $n }}+ étoiles</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase">Note minimum (/10)</label>
                        <select name="note_min" class="w-full mt-1 rounded-lg border-gray-300 text-sm focus:ring-violet-600 focus:border-violet-600">
                            <option value="">Toutes</option>
                            @foreach([5,6,7,8,9] as $n)
                                <option value="{{ $n }}" @selected(request('note_min') == $n)>{{ $n }}+ / 10</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="w-full py-2 bg-violet-700 text-white rounded-lg font-semibold">Appliquer</button>
                    <a href="{{ route('hotels.index') }}" class="block text-center text-sm text-violet-700 hover:underline">Réinitialiser les filtres</a>
                </div>
            </form>
        </aside>

        {{-- RÉSULTATS --}}
        <div class="lg:col-span-3">
            <p class="text-sm text-gray-500 mb-4">{{ $hotels->total() }} hôtel(s) trouvé(s)</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                @forelse($hotels as $hotel)
                    <x-hotel-card :hotel="$hotel" />
                @empty
                    <p class="col-span-full text-center text-gray-400 py-16">Aucun hôtel ne correspond à votre recherche.</p>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $hotels->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
