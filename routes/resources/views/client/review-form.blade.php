@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto px-4 py-10">
    <h1 class="text-2xl font-bold text-gray-900 mb-1">Donner votre avis</h1>
    <p class="text-gray-500 mb-6">{{ $hotel->nom }}</p>

    <form method="POST" action="{{ route('client.reviews.store', $hotel) }}" class="bg-white rounded-xl shadow border border-gray-100 p-6 space-y-5">
        @csrf
        <div>
            <label class="text-xs font-semibold text-gray-500 uppercase mb-1 block">Votre note (/10)</label>
            <input type="range" min="0" max="10" name="note" value="{{ old('note', $avisExistant->note ?? 8) }}"
                   oninput="document.getElementById('note-valeur').textContent = this.value"
                   class="w-full accent-violet-700">
            <div id="note-valeur" class="text-center text-2xl font-bold text-violet-700">{{ old('note', $avisExistant->note ?? 8) }}</div>
        </div>
        <div>
            <label class="text-xs font-semibold text-gray-500 uppercase">Commentaire (optionnel)</label>
            <textarea name="commentaire" rows="4" class="w-full mt-1 rounded-lg border-gray-300">{{ old('commentaire', $avisExistant->commentaire ?? '') }}</textarea>
            @error('commentaire') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="w-full py-3 bg-violet-700 hover:bg-violet-800 text-white font-semibold rounded-lg transition">
            {{ $avisExistant ? 'Mettre à jour mon avis' : 'Envoyer mon avis' }}
        </button>
    </form>
</div>
@endsection
