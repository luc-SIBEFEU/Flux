@extends('layouts.dashboard')
@php $espaceRole = auth()->user()->role; @endphp
@section('titre_page', __('annonces_page.mes_annonces'))
@section('titre', __('annonces_page.mes_annonces') . ' — ' . __('sidebar.mon_espace'))

@section('contenu')

<div class="flex items-center justify-between mb-6 flex-wrap gap-3">
    <p class="text-sm text-flux-noir/50">{{ trans_choice('annonces_page.annonces_compte', $annonces->count(), ['n' => $annonces->count()]) }}</p>

    @if(auth()->user()->peutUtiliserFonctionsPro())
        <a href="{{ route('annonces.manage.create') }}" class="inline-flex items-center gap-2 bg-flux-or hover:bg-flux-or-vif text-flux-noir text-sm font-semibold px-4 py-2.5 rounded-lg">
            <x-icon name="plus" class="w-4 h-4" /> {{ __('annonces_page.nouvelle_annonce') }}
        </a>
    @endif
</div>

@unless(auth()->user()->peutUtiliserFonctionsPro())
    <div class="bg-flux-or/10 border border-flux-or/30 text-flux-noir rounded-2xl p-5 mb-6 flex items-start gap-3">
        <x-icon name="sparkles" class="w-5 h-5 text-flux-or shrink-0 mt-0.5" />
        <div>
            <p class="font-medium">{{ __('annonces_page.reserve_pro_titre') }}</p>
            <p class="text-sm text-flux-noir/60 mt-1">{{ __('annonces_page.reserve_pro_desc') }}</p>
            <a href="{{ route('forfait.index') }}" class="inline-block mt-3 text-sm font-medium text-flux-bleu hover:underline">{{ __('annonces_page.voir_forfaits') }} →</a>
        </div>
    </div>
@endunless

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
    @forelse($annonces as $annonce)
        <div class="bg-white border border-black/10 rounded-2xl overflow-hidden">
            <div class="relative">
                @if($annonce->image)
                    <img src="{{ asset('storage/'.$annonce->image) }}" class="w-full h-36 object-cover">
                @else
                    <div class="w-full h-36 bg-flux-or/10 flex items-center justify-center">
                        <x-icon name="megaphone" class="w-8 h-8 text-flux-or/50" />
                    </div>
                @endif
                <span class="absolute top-3 left-3 text-xs font-semibold px-2.5 py-1 rounded-full {{ $annonce->visible ? 'bg-flux-bleu-pale text-flux-bleu' : 'bg-flux-noir/10 text-flux-noir/50' }}">
                    {{ $annonce->visible ? __('annonces_page.publiee') : __('annonces_page.masquee_admin') }}
                </span>
            </div>
            <div class="p-4">
                <h3 class="font-medium text-flux-noir truncate">{{ $annonce->titre }}</h3>
                <p class="text-sm text-flux-noir/50 flex items-center gap-1 mt-1">
                    <x-icon name="map-pin" class="w-3.5 h-3.5" /> {{ $annonce->ville }}
                </p>
                <p class="text-xs text-flux-noir/40 mt-1">{{ __('annonces_page.categorie_' . $annonce->categorie) }} · {{ $annonce->created_at->format('d/m/Y') }}</p>

                <div class="flex gap-3 mt-4 text-sm">
                    <a href="{{ route('annonces.manage.edit', $annonce) }}" class="flex items-center gap-1 text-flux-bleu font-medium">
                        <x-icon name="pencil" class="w-4 h-4" /> {{ __('common.modifier') }}
                    </a>
                    <form action="{{ route('annonces.manage.destroy', $annonce) }}" method="POST" onsubmit="return confirm('{{ __('annonces_page.confirmer_suppression') }}')">
                        @csrf @method('DELETE')
                        <button class="flex items-center gap-1 text-red-500 font-medium">
                            <x-icon name="trash" class="w-4 h-4" /> {{ __('common.supprimer') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center py-16 text-flux-noir/40">
            <x-icon name="megaphone" class="w-10 h-10 mx-auto mb-3" />
            {{ __('annonces_page.aucune_annonce_perso') }}
        </div>
    @endforelse
</div>

@endsection
