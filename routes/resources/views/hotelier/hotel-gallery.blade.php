@extends('layouts.hotelier')

@section('content')
<div class="p-6">
    <a href="{{ route('hotelier.hotels.index') }}" class="text-sm text-violet-700">← Retour à mes hôtels</a>
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Galerie photo — {{ $hotel->nom }}</h1>

    <form method="POST" action="{{ route('hotelier.gallery.store', $hotel) }}" enctype="multipart/form-data" class="bg-white rounded-xl shadow border border-gray-100 p-5 mb-6">
        @csrf
        <label class="text-xs font-semibold text-gray-500 uppercase">Ajouter des images</label>
        <input type="file" name="images[]" multiple class="w-full mt-1">
        @error('images.*') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
        <button type="submit" class="mt-3 px-4 py-2 bg-violet-700 text-white rounded-lg font-semibold">Téléverser</button>
    </form>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach($images as $image)
        <div class="relative group">
            <img src="{{ $image->imageUrl() }}" class="w-full h-32 object-cover rounded-lg">
            <form method="POST" action="{{ route('hotelier.gallery.destroy', [$hotel, $image]) }}" onsubmit="return confirm('Supprimer cette image ?');" class="absolute top-1 right-1">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white rounded-full w-6 h-6 text-xs opacity-0 group-hover:opacity-100 transition">✕</button>
            </form>
        </div>
        @endforeach
    </div>
</div>
@endsection
