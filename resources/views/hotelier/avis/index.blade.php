@extends('layouts.dashboard')
@php $espaceRole = 'hotelier'; @endphp
@section('titre_page', 'Avis clients')
@section('titre', 'Avis — Hôtelier')

@section('contenu')

<form method="GET" class="flex flex-col sm:flex-row gap-3 mb-6">
    <select name="hotel_id" onchange="this.form.submit()" class="border border-black/10 rounded-lg px-3 py-2.5 text-sm bg-white">
        <option value="">Tous mes hôtels</option>
        @foreach($hotels as $h)
            <option value="{{ $h->id }}" {{ request('hotel_id')==$h->id?'selected':'' }}>{{ $h->nom }}</option>
        @endforeach
    </select>
    <select name="note_min" onchange="this.form.submit()" class="border border-black/10 rounded-lg px-3 py-2.5 text-sm bg-white">
        <option value="">Toutes les notes</option>
        @foreach([8,6,4,2] as $n)
            <option value="{{ $n }}" {{ request('note_min')==$n?'selected':'' }}>{{ $n }}/10 et plus</option>
        @endforeach
    </select>
</form>

<div class="space-y-4">
    @forelse($avis as $avi)
        <div class="bg-white border border-black/10 rounded-2xl p-5">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <span class="font-medium">{{ $avi->client->nom }}</span>
                    <span class="text-flux-noir/40 text-sm"> — {{ $avi->hotel->nom }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="flex items-center gap-1 text-flux-or font-semibold text-sm"><x-icon name="star-filled" class="w-4 h-4" /> {{ $avi->note }}/10</span>
                    @php $badges = ['en_attente'=>'bg-flux-or/20 text-flux-or','approuve'=>'bg-flux-bleu-pale text-flux-bleu','rejete'=>'bg-red-50 text-red-500']; @endphp
                    <span class="text-xs px-2.5 py-1 rounded-full font-medium {{ $badges[$avi->statut] }}">{{ ucfirst($avi->statut) }}</span>
                </div>
            </div>
            <p class="text-sm text-flux-noir/60">{{ $avi->commentaire }}</p>
        </div>
    @empty
        <div class="text-center py-16 text-flux-noir/40">
            <x-icon name="star" class="w-10 h-10 mx-auto mb-3" />
            Aucun avis pour vos hôtels pour le moment.
        </div>
    @endforelse
</div>

<div class="mt-8">{{ $avis->links() }}</div>
@endsection
