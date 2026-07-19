@extends('layouts.admin')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Modération des avis</h1>

    <div class="flex gap-2 mb-6">
        @foreach(['en_attente' => 'En attente', 'approuve' => 'Approuvés', 'rejete' => 'Rejetés', 'tout' => 'Tous'] as $val => $label)
            <a href="{{ route('admin.reviews.index', ['filtre' => $val]) }}"
               class="px-4 py-2 rounded-full text-sm font-medium {{ $filtre === $val ? 'bg-violet-700 text-white' : 'bg-white text-gray-600 border' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    <div class="space-y-4">
        @forelse($reviews as $avis)
        <div class="bg-white rounded-xl shadow border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <span class="font-semibold text-gray-900">{{ $avis->client->nom }}</span>
                    <span class="text-gray-400 text-sm"> → {{ $avis->hotel->nom }}</span>
                </div>
                <span class="text-amber-500 font-bold">{{ $avis->note }}/10</span>
            </div>
            @if($avis->commentaire)
                <p class="text-gray-600 text-sm mt-2">{{ $avis->commentaire }}</p>
            @endif

            <div class="flex items-center justify-between mt-3">
                <span class="text-xs px-2 py-0.5 rounded-full
                    {{ $avis->statut === 'approuve' ? 'bg-green-100 text-green-700' : ($avis->statut === 'rejete' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">
                    {{ ucfirst(str_replace('_', ' ', $avis->statut)) }}
                </span>

                @if($avis->statut === 'en_attente')
                <div class="flex gap-2">
                    <form method="POST" action="{{ route('admin.reviews.approuver', $avis) }}">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="px-3 py-1.5 bg-green-600 text-white text-sm rounded-lg">Approuver</button>
                    </form>
                    <form method="POST" action="{{ route('admin.reviews.rejeter', $avis) }}">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="px-3 py-1.5 bg-red-600 text-white text-sm rounded-lg">Rejeter</button>
                    </form>
                </div>
                @endif
            </div>
        </div>
        @empty
        <p class="text-gray-400 text-center py-10">Aucun avis dans cette catégorie.</p>
        @endforelse
    </div>

    <div class="mt-6">{{ $reviews->links() }}</div>
</div>
@endsection
