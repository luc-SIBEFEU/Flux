@extends('layouts.dashboard')
@php($espaceRole = 'client')
@section('titre_page', __('aide.guide_notice'))
@section('titre', __('aide.titre_client'))

@section('contenu')
<div class="max-w-3xl space-y-8">

    <div class="bg-white border border-black/10 rounded-2xl p-6">
        <h2 class="font-display text-xl mb-3 flex items-center gap-2"><x-icon name="calendar" class="w-5 h-5 text-flux-bleu" /> {{ __('aide.client.reserver_hotel_titre') }}</h2>
        <ul class="space-y-2 text-sm text-flux-noir/70 list-disc list-inside">
            <li>{{ __('aide.client.reserver_hotel_li1') }}</li>
            <li>{{ __('aide.client.reserver_hotel_li2') }}</li>
            <li>{{ __('aide.client.reserver_hotel_li3') }}</li>
            <li>{{ __('aide.client.reserver_hotel_li4') }}</li>
        </ul>
    </div>

    <div class="bg-white border border-black/10 rounded-2xl p-6">
        <h2 class="font-display text-xl mb-3 flex items-center gap-2"><x-icon name="key" class="w-5 h-5 text-flux-violet" /> {{ __('aide.client.louer_logement_titre') }}</h2>
        <ul class="space-y-2 text-sm text-flux-noir/70 list-disc list-inside">
            <li>{{ __('aide.client.louer_logement_li1') }}</li>
            <li>{!! __('aide.client.louer_logement_li2') !!}</li>
            <li>{!! __('aide.client.louer_logement_li3') !!}</li>
            <li>{!! __('aide.client.louer_logement_li4') !!}</li>
            <li>{{ __('aide.client.louer_logement_li5') }}</li>
        </ul>
    </div>

    <div class="bg-white border border-black/10 rounded-2xl p-6">
        <h2 class="font-display text-xl mb-3 flex items-center gap-2"><x-icon name="heart" class="w-5 h-5 text-flux-violet" /> {{ __('aide.client.favoris_avis_titre') }}</h2>
        <p class="text-sm text-flux-noir/70">{{ __('aide.client.favoris_avis_desc') }}</p>
    </div>

</div>
@endsection
