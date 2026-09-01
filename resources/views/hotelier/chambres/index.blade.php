@extends('layouts.dashboard')
@php $espaceRole = 'hotelier'; @endphp
@section('titre_page', __('hotel.chambres') . ' — ' . $hotel->nom)
@section('titre', __('hotel.chambres') . ' — ' . __('sidebar.espace_hotelier'))

@section('contenu')

<div class="flex items-center justify-between mb-6 flex-wrap gap-3">
    <p><a href="{{ route('hotelier.hotels.index') }}" class="text-sm text-flux-noir/50 hover:text-flux-bleu">{{ __('navigation.hotels') }}</a> > {{ $hotel->nom }}</p>
    <div class="flex gap-3">
        <form method="GET" class="flex items-center gap-2 border border-black/10 rounded-lg px-3 py-2 bg-white">
            <x-icon name="search" class="w-4 h-4 text-flux-noir/40" />
            <input type="text" name="recherche" value="{{ request('recherche') }}" placeholder="{{ __('chambre.rechercher_categorie') }}" class="outline-none text-sm">
        </form>
        <a href="{{ route('hotelier.hotels.chambres.create', $hotel) }}" class="inline-flex items-center gap-2 bg-flux-bleu text-white text-sm font-medium px-4 py-2.5 rounded-lg">
            <x-icon name="plus" class="w-4 h-4" /> {{ __('chambre.nouvelle_categorie') }}
        </a>
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
    @forelse($chambres as $chambre)
        <div class="bg-white border border-black/10 rounded-2xl p-5">
            <h3 class="font-medium">{{ $chambre->nom }}</h3>
            <p class="text-sm text-flux-noir/50 flex items-center gap-1 mt-1">
                <x-icon name="users" class="w-3.5 h-3.5" /> {{ trans_choice('chambre.adulte_compte', $chambre->capacite_adultes, ['n' => $chambre->capacite_adultes]) }} · {{ trans_choice('chambre.enfant_compte', $chambre->capacite_enfants, ['n' => $chambre->capacite_enfants]) }}
            </p>
            <p class="font-display text-lg text-flux-bleu mt-2">{{ number_format($chambre->prix_nuit,0,',',' ') }} F<span class="text-xs font-sans text-flux-noir/40">{{ __('chambre.par_nuit') }}</span></p>
            <p class="text-xs text-flux-noir/40 mt-1">{{ trans_choice('chambre.reservation_compte', $chambre->reservations_count, ['n' => $chambre->reservations_count]) }}</p>

            <div class="flex gap-3 mt-4">
                <a href="{{ route('hotelier.hotels.chambres.edit', [$hotel, $chambre]) }}" class="inline-flex items-center gap-1.5 text-sm text-flux-bleu font-medium">
                    <x-icon name="pencil" class="w-4 h-4" /> {{ __('common.modifier') }}
                </a>
                <form action="{{ route('hotelier.hotels.chambres.destroy', [$hotel, $chambre]) }}" method="POST" onsubmit="return confirm('{{ __('chambre.confirmer_suppression') }}')">
                    @csrf @method('DELETE')
                    <button class="inline-flex items-center gap-1.5 text-sm text-red-500 font-medium">
                        <x-icon name="trash" class="w-4 h-4" /> {{ __('common.supprimer') }}
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center py-16 text-flux-noir/40">
            <x-icon name="key" class="w-10 h-10 mx-auto mb-3" />
            {{ __('chambre.aucune_categorie') }}
        </div>
    @endforelse
</div>
@endsection
