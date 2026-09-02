@extends('layouts.dashboard')
@php($espaceRole = 'bailleur')
@section('titre_page', __('sidebar.mes_minicites'))
@section('titre', __('sidebar.mes_minicites') . ' — ' . __('sidebar.espace_bailleur'))

@section('contenu')

<div class="flex items-center justify-between mb-6 flex-wrap gap-3">
    <p class="text-sm text-flux-noir/50">{{ $minicites->count() }} mini-cité(s)</p>
    <div class="flex gap-3">
        <form method="GET" class="flex items-center gap-2 border border-black/10 rounded-lg px-3 py-2 bg-white">
            <x-icon name="map-pin" class="w-4 h-4 text-flux-noir/40" />
            <input type="text" name="ville" value="{{ request('ville') }}" placeholder="{{ __('common.filtrer_par_ville') }}" class="outline-none text-sm">
        </form>
        <a href="{{ route('bailleur.minicites.create') }}" class="inline-flex items-center gap-2 bg-flux-violet text-white text-sm font-medium px-4 py-2.5 rounded-lg">
            <x-icon name="plus" class="w-4 h-4" /> {{ __('minicite.nouvelle_minicite') }}
        </a>
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
    @forelse($minicites as $mc)
        <div class="bg-white border border-black/10 rounded-2xl p-5">
            <h3 class="font-medium">{{ $mc->nom }}</h3>
            <p class="text-sm text-flux-noir/50 flex items-center gap-1 mt-1"><x-icon name="map-pin" class="w-3.5 h-3.5" /> {{ $mc->quartier }}, {{ $mc->ville }}</p>
            <p class="text-xs text-flux-noir/40 mt-2">{{ trans_choice('logement.logement_compte', $mc->logements_count, ['n' => $mc->logements_count]) }}</p>

            <div class="flex gap-3 mt-4">
                <a href="{{ route('bailleur.minicites.edit', $mc) }}" class="inline-flex items-center gap-1.5 text-sm text-flux-violet font-medium">
                    <x-icon name="pencil" class="w-4 h-4" /> {{ __('common.modifier') }}
                </a>
                <form action="{{ route('bailleur.minicites.destroy', $mc) }}" method="POST" onsubmit="return confirm('{{ __('minicite.confirmer_suppression') }}')">
                    @csrf @method('DELETE')
                    <button class="inline-flex items-center gap-1.5 text-sm text-red-500 font-medium">
                        <x-icon name="trash" class="w-4 h-4" /> {{ __('common.supprimer') }}
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center py-16 text-flux-noir/40">
            <x-icon name="map-pin" class="w-10 h-10 mx-auto mb-3" />
            {{ __('minicite.aucune_minicite') }}
        </div>
    @endforelse
</div>
@endsection
