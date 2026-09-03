@extends('layouts.app')
@section('titre', $annonce->titre . ' — Flux')

@section('contenu')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
    <div class="text-sm text-flux-noir/50 mb-4">
        <a class="hover:text-flux-or" href="{{ route('annonces.index') }}">{{ __('navigation.annonces') }}</a> > {{ $annonce->titre }}
    </div>

    @if($annonce->image)
        <img src="{{ asset('storage/'.$annonce->image) }}" alt="{{ $annonce->titre }}" class="w-full h-64 sm:h-80 object-cover rounded-2xl mb-6">
    @endif

    <div class="flex items-center gap-2 mb-3">
        <span class="text-xs font-semibold bg-flux-or/15 text-flux-or px-2.5 py-1 rounded-full">{{ __('annonces_page.categorie_' . $annonce->categorie) }}</span>
        <span class="text-xs text-flux-noir/40 flex items-center gap-1">
            <x-icon name="map-pin" class="w-3.5 h-3.5" /> {{ $annonce->ville }}
        </span>
    </div>

    <h1 class="font-display text-3xl sm:text-4xl text-flux-noir mb-4">{{ $annonce->titre }}</h1>

    <div class="flex items-center gap-2 text-sm text-flux-noir/60 mb-8">
        <x-icon name="{{ $annonce->auteur->role === 'hotelier' ? 'building' : 'key' }}" class="w-4 h-4" />
        {{ __('annonces_page.publie_par_x', ['nom' => $annonce->auteur->nom]) }}
        · {{ $annonce->created_at->format('d/m/Y') }}
    </div>

    {{-- Contenu saisi via l'éditeur de texte enrichi, déjà assaini côté serveur à l'enregistrement. --}}
    <div class="contenu-riche text-flux-noir/80 leading-relaxed">
        {!! $annonce->contenu !!}
    </div>

    <div class="mt-10 pt-8 border-t border-black/10">
        <a href="{{ route('annonces.index') }}" class="text-sm text-flux-bleu font-medium hover:underline">← {{ __('annonces_page.retour_annonces') }}</a>
    </div>
</div>
@endsection
