@props(['hotel'])

<a href="{{ route('hotels.show', $hotel) }}"
   class="group bg-white rounded-xl shadow border border-gray-100 overflow-hidden hover:shadow-xl transition block">
    <div class="relative h-44 overflow-hidden bg-gray-100">
        @if($hotel->imageCouvertureUrl())
            <img src="{{ $hotel->imageCouvertureUrl() }}" alt="{{ $hotel->nom }}"
                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
        @else
            <div class="w-full h-full flex items-center justify-center text-gray-300 text-4xl">🏨</div>
        @endif

        @if($hotel->logoUrl())
            <img src="{{ $hotel->logoUrl() }}" alt="Logo {{ $hotel->nom }}"
                 class="absolute bottom-2 left-2 w-10 h-10 rounded-full object-cover border-2 border-white shadow">
        @endif

        <div class="absolute top-2 right-2 bg-black/70 text-amber-400 text-xs font-bold px-2 py-1 rounded-full">
            {{ number_format($hotel->note_moyenne, 1) }}/10
        </div>
    </div>

    <div class="p-4">
        <div class="flex items-center gap-1 text-amber-500 text-sm mb-1">
            @for($i = 0; $i < $hotel->nombre_etoiles; $i++) ★ @endfor
        </div>
        <h3 class="font-semibold text-gray-900 truncate">{{ $hotel->nom }}</h3>
        <p class="text-sm text-gray-500">📍 {{ $hotel->ville }}</p>
        <p class="text-xs text-gray-400 mt-1">{{ $hotel->nombre_avis }} avis</p>
    </div>
</a>
