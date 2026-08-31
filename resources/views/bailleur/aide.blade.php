@extends('layouts.dashboard')
@php($espaceRole = 'bailleur')
@section('titre_page', __('aide.guide_notice'))
@section('titre', __('aide.titre_bailleur'))

@section('contenu')
<div class="max-w-3xl space-y-8">

    <div class="bg-white border border-black/10 rounded-2xl p-6">
        <h2 class="font-display text-xl mb-3 flex items-center gap-2"><x-icon name="building" class="w-5 h-5 text-flux-violet" /> {{ __('aide.bailleur.ajouter_logement_titre') }}</h2>
        <ul class="space-y-2 text-sm text-flux-noir/70 list-disc list-inside">
            <li>{{ __('aide.bailleur.ajouter_logement_li1') }}</li>
            <li>{!! __('aide.bailleur.ajouter_logement_li2') !!}</li>
            <li>{!! __('aide.bailleur.ajouter_logement_li3') !!}</li>
            <li>{!! __('aide.bailleur.ajouter_logement_li4') !!}</li>
        </ul>
    </div>

    <div class="bg-white border border-black/10 rounded-2xl p-6">
        <h2 class="font-display text-xl mb-3 flex items-center gap-2"><x-icon name="bell" class="w-5 h-5 text-flux-or" /> {{ __('aide.bailleur.demandes_baye_titre') }}</h2>
        <ul class="space-y-2 text-sm text-flux-noir/70 list-disc list-inside">
            <li>{{ __('aide.bailleur.demandes_baye_li1') }}</li>
            <li>{!! __('aide.bailleur.demandes_baye_li2') !!}</li>
            <li>{{ __('aide.bailleur.demandes_baye_li3') }}</li>
        </ul>
    </div>

    <div class="bg-white border border-black/10 rounded-2xl p-6">
        <h2 class="font-display text-xl mb-3 flex items-center gap-2"><x-icon name="key" class="w-5 h-5 text-flux-violet" /> {{ __('aide.bailleur.prolongations_titre') }}</h2>
        <ul class="space-y-2 text-sm text-flux-noir/70 list-disc list-inside">
            <li>{!! __('aide.bailleur.prolongations_li1') !!}</li>
            <li>{{ __('aide.bailleur.prolongations_li2') }}</li>
        </ul>
    </div>

    <div class="bg-white border border-black/10 rounded-2xl p-6">
        <h2 class="font-display text-xl mb-3 flex items-center gap-2"><x-icon name="coins" class="w-5 h-5 text-flux-or" /> {{ __('aide.bailleur.recevoir_loyers_titre') }}</h2>
        <p class="text-sm text-flux-noir/70">{{ __('aide.bailleur.recevoir_loyers_desc') }}</p>
    </div>

</div>
@endsection
