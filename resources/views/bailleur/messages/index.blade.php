@extends('layouts.dashboard')
@php $espaceRole = 'bailleur'; @endphp
@section('titre_page', 'Messages')
@section('titre', 'Messages — Bailleur')

@section('contenu')

<p class="text-sm text-flux-noir/60 mb-6">
    Messages envoyés par des clients intéressés par vos logements en forfait <strong>free</strong> (non réservables en ligne).
    Passez en <a href="{{ route('forfait.index') }}" class="text-flux-bleu underline">forfait pro</a> pour activer la réservation en ligne.
</p>

<div class="space-y-4">
    @forelse ($messages as $message)
        <div class="bg-white border border-black/10 rounded-2xl p-5">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <span class="font-medium">{{ $message->client->nom }}</span>
                    <span class="text-flux-noir/40 text-sm"> — {{ $message->contactable->nom }}</span>
                </div>
                <span class="text-xs text-flux-noir/40">{{ $message->created_at->diffForHumans() }}</span>
            </div>
            <p class="text-sm text-flux-noir/60 mb-2">{{ $message->message }}</p>
            <a href="tel:{{ $message->telephone_client }}" class="inline-flex items-center gap-1.5 text-sm text-flux-bleu font-medium">
                <x-icon name="phone" class="w-4 h-4" /> {{ $message->telephone_client }}
            </a>
        </div>
    @empty
        <div class="text-center py-16 text-flux-noir/40">
            <x-icon name="mail" class="w-10 h-10 mx-auto mb-3" />
            Aucun message pour le moment.
        </div>
    @endforelse
</div>

<div class="mt-8">{{ $messages->links() }}</div>
@endsection
