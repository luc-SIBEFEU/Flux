@extends('layouts.dashboard')
@php($espaceRole = 'admin')
@section('titre_page', 'Modération des avis')
@section('titre', 'Avis — Admin')

@section('contenu')

<form method="GET" class="mb-6">
    <select name="note_min" onchange="this.form.submit()" class="border border-black/10 rounded-lg px-3 py-2.5 text-sm bg-white">
        <option value="">Toutes les notes</option>
        @foreach([8,6,4,2] as $n)
            <option value="{{ $n }}" {{ request('note_min')==$n?'selected':'' }}>{{ $n }}/10 et plus</option>
        @endforeach
    </select>
</form>

<p class="text-sm text-flux-noir/50 mb-6">{{ $avis->total() }} avis en attente de modération</p>

<div class="space-y-4">
    @forelse($avis as $avi)
        <div class="bg-white border border-black/10 rounded-2xl p-5">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <span class="font-medium">{{ $avi->client->nom }}</span>
                    <span class="text-flux-noir/40 text-sm"> à propos de </span>
                    <span class="font-medium text-flux-bleu">{{ $avi->hotel->nom }}</span>
                </div>
                <span class="flex items-center gap-1 text-flux-or font-semibold text-sm"><x-icon name="star-filled" class="w-4 h-4" /> {{ $avi->note }}/10</span>
            </div>
            <p class="text-sm text-flux-noir/60 mb-4">{{ $avi->commentaire }}</p>
            <div class="flex gap-3">
                <form action="{{ route('admin.avis.approuver', $avi) }}" method="POST">
                    @csrf
                    <button class="inline-flex items-center gap-1.5 bg-flux-bleu text-white text-sm font-medium px-4 py-2 rounded-lg">
                        <x-icon name="check-circle" class="w-4 h-4" /> Approuver
                    </button>
                </form>
                <form action="{{ route('admin.avis.rejeter', $avi) }}" method="POST">
                    @csrf
                    <button class="inline-flex items-center gap-1.5 bg-red-50 text-red-600 text-sm font-medium px-4 py-2 rounded-lg">
                        <x-icon name="x-circle" class="w-4 h-4" /> Rejeter
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="text-center py-16 text-flux-noir/40">
            <x-icon name="star" class="w-10 h-10 mx-auto mb-3" />
            Aucun avis en attente.
        </div>
    @endforelse
</div>

<div class="mt-8">{{ $avis->links() }}</div>
@endsection
