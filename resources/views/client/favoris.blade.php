@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Mes favoris</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse($hotels as $hotel)
        <div class="relative">
            <x-hotel-card :hotel="$hotel" />
            <form method="POST" action="{{ route('client.favoris.destroy', $hotel) }}" class="absolute top-2 left-2">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-white/90 text-red-500 rounded-full w-8 h-8 flex items-center justify-center shadow">❤️</button>
            </form>
        </div>
        @empty
        <p class="text-gray-400 col-span-full text-center py-16">Vous n'avez pas encore de favoris.</p>
        @endforelse
    </div>
</div>
@endsection
