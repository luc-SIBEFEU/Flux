@extends('layouts.dashboard')
@php($espaceRole = 'hotelier')
@section('titre_page', __('aide.guide_notice'))
@section('titre', __('aide.titre_hotelier'))

@section('contenu')
<div class="max-w-3xl space-y-8">

    <div class="bg-white border border-black/10 rounded-2xl p-6">
        <h2 class="font-display text-xl mb-3 flex items-center gap-2"><x-icon name="building" class="w-5 h-5 text-flux-bleu" /> {{ __('aide.hotelier.creer_hotel_titre') }}</h2>
        <ul class="space-y-2 text-sm text-flux-noir/70 list-disc list-inside">
            <li>{{ __('aide.hotelier.creer_hotel_li1') }}</li>
            <li>{!! __('aide.hotelier.creer_hotel_li2') !!}</li>
            <li>{{ __('aide.hotelier.creer_hotel_li3') }}</li>
            <li>{{ __('aide.hotelier.creer_hotel_li4') }}</li>
        </ul>
    </div>

    <div class="bg-white border border-black/10 rounded-2xl p-6">
        <h2 class="font-display text-xl mb-3 flex items-center gap-2"><x-icon name="key" class="w-5 h-5 text-flux-bleu" /> {{ __('aide.hotelier.categories_chambres_titre') }}</h2>
        <p class="text-sm text-flux-noir/70">{{ __('aide.hotelier.categories_chambres_desc') }}</p>
    </div>

    <div class="bg-white border border-black/10 rounded-2xl p-6">
        <h2 class="font-display text-xl mb-3 flex items-center gap-2"><x-icon name="calendar" class="w-5 h-5 text-flux-bleu" /> {{ __('aide.hotelier.reservations_titre') }}</h2>
        <ul class="space-y-2 text-sm text-flux-noir/70 list-disc list-inside">
            <li>{{ __('aide.hotelier.reservations_li1') }}</li>
            <li>{{ __('aide.hotelier.reservations_li2') }}</li>
            <li>{{ __('aide.hotelier.reservations_li3') }}</li>
        </ul>
    </div>

    <div class="bg-white border border-black/10 rounded-2xl p-6">
        <h2 class="font-display text-xl mb-3 flex items-center gap-2"><x-icon name="star" class="w-5 h-5 text-flux-or" /> {{ __('aide.hotelier.avis_titre') }}</h2>
        <p class="text-sm text-flux-noir/70">{{ __('aide.hotelier.avis_desc') }}</p>
    </div>

</div>
@endsection
