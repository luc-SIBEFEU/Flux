@extends('layouts.dashboard')
@php($espaceRole = 'bailleur')
@section('titre_page', 'Commentaires')
@section('titre', 'Commentaires — Bailleur')

@section('contenu')

<form method="GET" class="flex flex-col sm:flex-row gap-3 mb-6">
    <select name="logement_id" onchange="this.form.submit()" class="border border-black/10 rounded-lg px-3 py-2.5 text-sm bg-white">
        <option value="">Tous mes logements</option>
        @foreach($logements as $l)
            <option value="{{ $l->id }}" {{ request('logement_id')==$l->id?'selected':'' }}>{{ __('logement.type_' . $l->type) }} — {{ $l->quartier }}</option>
        @endforeach
    </select>
    <select name="note_min" onchange="this.form.submit()" class="border border-black/10 rounded-lg px-3 py-2.5 text-sm bg-white">
        <option value="">Toutes les notes</option>
        @foreach([8,6,4,2] as $n)
            <option value="{{ $n }}" {{ request('note_min')==$n?'selected':'' }}>{{ __('avis.note_et_plus', ['n' => $n]) }}</option>
        @endforeach
    </select>
</form>

<div class="space-y-4">
    @forelse($commentaires as $com)
        <div class="bg-white border border-black/10 rounded-2xl p-5">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <span class="font-medium">{{ $com->client->nom }}</span>
                    <span class="text-flux-noir/40 text-sm capitalize"> — {{ $com->logement->type }}, {{ $com->logement->quartier }}</span>
                </div>
                <span class="flex items-center gap-1 text-flux-or font-semibold text-sm"><x-icon name="star-filled" class="w-4 h-4" /> {{ $com->note }}/10</span>
            </div>
            <p class="text-sm text-flux-noir/60">{{ $com->commentaire }}</p>
        </div>
    @empty
        <div class="text-center py-16 text-flux-noir/40">
            <x-icon name="star" class="w-10 h-10 mx-auto mb-3" />
            Aucun commentaire pour vos logements.
        </div>
    @endforelse
</div>

<div class="mt-8">{{ $commentaires->links() }}</div>
@endsection
