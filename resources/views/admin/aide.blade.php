@extends('layouts.dashboard')
@php($espaceRole = 'admin')
@section('titre_page', __('aide.guide_notice'))
@section('titre', __('aide.titre_admin'))

@section('contenu')
<div class="max-w-3xl space-y-8">

    <div class="bg-white border border-black/10 rounded-2xl p-6">
        <h2 class="font-display text-xl mb-3 flex items-center gap-2"><x-icon name="check-circle" class="w-5 h-5 text-flux-bleu" /> {{ __('aide.admin.validations_titre') }}</h2>
        <ul class="space-y-2 text-sm text-flux-noir/70 list-disc list-inside">
            <li>{!! __('aide.admin.validations_li1') !!}</li>
            <li>{!! __('aide.admin.validations_li2') !!}</li>
            <li>{!! __('aide.admin.validations_li3') !!}</li>
            <li>{{ __('aide.admin.validations_li4') }}</li>
        </ul>
    </div>

    <div class="bg-white border border-black/10 rounded-2xl p-6">
        <h2 class="font-display text-xl mb-3 flex items-center gap-2"><x-icon name="star" class="w-5 h-5 text-flux-or" /> {{ __('aide.admin.moderation_titre') }}</h2>
        <p class="text-sm text-flux-noir/70">{{ __('aide.admin.moderation_desc') }}</p>
    </div>

    <div class="bg-white border border-black/10 rounded-2xl p-6">
        <h2 class="font-display text-xl mb-3 flex items-center gap-2"><x-icon name="cog" class="w-5 h-5 text-flux-noir/60" /> {{ __('aide.admin.consultation_titre') }}</h2>
        <p class="text-sm text-flux-noir/70">{{ __('aide.admin.consultation_desc') }}</p>
    </div>

    <div class="bg-white border border-black/10 rounded-2xl p-6">
        <h2 class="font-display text-xl mb-3 flex items-center gap-2"><x-icon name="coins" class="w-5 h-5 text-flux-or" /> {{ __('aide.admin.rapports_titre') }}</h2>
        <p class="text-sm text-flux-noir/70">{{ __('aide.admin.rapports_desc') }}</p>
    </div>

    <div class="bg-white border border-black/10 rounded-2xl p-6">
        <h2 class="font-display text-xl mb-3 flex items-center gap-2"><x-icon name="bell" class="w-5 h-5 text-flux-bleu" /> {{ __('aide.admin.automatisations_titre') }}</h2>
        <p class="text-sm text-flux-noir/70">{!! __('aide.admin.automatisations_desc') !!}</p>
    </div>

</div>
@endsection
