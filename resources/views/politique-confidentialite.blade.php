@extends('layouts.app')
@section('titre', __('pages.politique_titre') . ' — Flux')

@section('contenu')
<section class="bg-flux-bleu text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
        <p class="text-flux-or text-sm font-medium uppercase tracking-widest">{{ __('legal.politique.hero_label') }}</p>
        <h1 class="font-display text-4xl sm:text-5xl mt-3">{{ __('pages.politique_titre') }}</h1>
        <p class="text-white/65 mt-5">{{ __('legal.derniere_maj') }} : {{ date('d/m/Y') }}</p>
    </div>
</section>

<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
    <div class="space-y-12 text-flux-noir/70 leading-relaxed">
        <div>
            <h2 class="font-display text-2xl text-flux-noir mb-3">{{ __('legal.politique.s1_titre') }}</h2>
            <p>{!! __('legal.politique.s1_corps') !!}</p>
        </div>
        <div>
            <h2 class="font-display text-2xl text-flux-noir mb-3">{{ __('legal.politique.s2_titre') }}</h2>
            <p>{!! __('legal.politique.s2_corps') !!}</p>
        </div>
        <div>
            <h2 class="font-display text-2xl text-flux-noir mb-3">{{ __('legal.politique.s3_titre') }}</h2>
            <p>{!! __('legal.politique.s3_corps') !!}</p>
        </div>
        <div>
            <h2 class="font-display text-2xl text-flux-noir mb-3">{{ __('legal.politique.s4_titre') }}</h2>
            <p>{!! __('legal.politique.s4_corps') !!}</p>
        </div>
        <div>
            <h2 class="font-display text-2xl text-flux-noir mb-3">{{ __('legal.politique.s5_titre') }}</h2>
            <p>{!! __('legal.politique.s5_corps') !!}</p>
        </div>
        <div>
            <h2 class="font-display text-2xl text-flux-noir mb-3">{{ __('legal.politique.s6_titre') }}</h2>
            <p>{!! __('legal.politique.s6_corps') !!}</p>
        </div>
        <div>
            <h2 class="font-display text-2xl text-flux-noir mb-3">{{ __('legal.politique.s7_titre') }}</h2>
            <p>{!! __('legal.politique.s7_corps') !!}</p>
        </div>
        <div>
            <h2 class="font-display text-2xl text-flux-noir mb-3">{{ __('legal.politique.s8_titre') }}</h2>
            <p>{!! __('legal.politique.s8_corps') !!}</p>
        </div>
    </div>
</section>
@endsection
