@extends('layouts.app')
@section('titre', __('faq.titre') . ' — Flux')

@section('contenu')
<section class="bg-flux-bleu text-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 sm:py-28">
        <p class="text-flux-or text-sm font-medium uppercase tracking-widest">{{ __('faq.centre_aide') }}</p>
        <h1 class="font-display text-4xl sm:text-6xl max-w-3xl mt-3 leading-tight">{{ __('faq.questions_frequentes') }}</h1>
        <p class="text-white/70 max-w-2xl mt-6 text-lg leading-relaxed">{{ __('faq.trouvez_reponses') }}</p>
    </div>
</section>

<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-20 sm:py-24">
    <!-- Voyageurs & Clients -->
    <div class="mb-16">
        <p class="text-flux-or text-sm font-medium uppercase tracking-widest mb-2">{{ __('faq.pour_voyageurs') }}</p>
        <h2 class="font-display text-3xl text-flux-noir mb-8">{{ __('faq.questions_voyageurs') }}</h2>
        
        <div class="space-y-5">
            <!-- FAQ Item 1 -->
            <details class="border border-flux-noir/10 rounded-lg p-6 cursor-pointer group">
                <summary class="flex items-center justify-between font-semibold text-flux-noir hover:text-flux-bleu transition-colors">
                    <span>{{ __('faq.q1') }}</span>
                    <x-icon name="chevron-down" class="w-5 h-5 text-flux-bleu transition-transform group-open:rotate-180" />
                </summary>
                <p class="text-flux-noir/70 leading-relaxed mt-4">
                    {{ __('faq.a1') }}
                </p>
            </details>

            <!-- FAQ Item 2 -->
            <details class="border border-flux-noir/10 rounded-lg p-6 cursor-pointer group">
                <summary class="flex items-center justify-between font-semibold text-flux-noir hover:text-flux-bleu transition-colors">
                    <span>{{ __('faq.q2') }}</span>
                    <x-icon name="chevron-down" class="w-5 h-5 text-flux-bleu transition-transform group-open:rotate-180" />
                </summary>
                <p class="text-flux-noir/70 leading-relaxed mt-4">
                    {{ __('faq.a2') }}
                </p>
            </details>

            <!-- FAQ Item 3 -->
            <details class="border border-flux-noir/10 rounded-lg p-6 cursor-pointer group">
                <summary class="flex items-center justify-between font-semibold text-flux-noir hover:text-flux-bleu transition-colors">
                    <span>{{ __('faq.q3') }}</span>
                    <x-icon name="chevron-down" class="w-5 h-5 text-flux-bleu transition-transform group-open:rotate-180" />
                </summary>
                <p class="text-flux-noir/70 leading-relaxed mt-4">
                    {{ __('faq.a3') }}
                </p>
            </details>

            <!-- FAQ Item 4 -->
            <details class="border border-flux-noir/10 rounded-lg p-6 cursor-pointer group">
                <summary class="flex items-center justify-between font-semibold text-flux-noir hover:text-flux-bleu transition-colors">
                    <span>{{ __('faq.q4') }}</span>
                    <x-icon name="chevron-down" class="w-5 h-5 text-flux-bleu transition-transform group-open:rotate-180" />
                </summary>
                <p class="text-flux-noir/70 leading-relaxed mt-4">
                    {{ __('faq.a4') }}
                </p>
            </details>

            <!-- FAQ Item 5 -->
            <details class="border border-flux-noir/10 rounded-lg p-6 cursor-pointer group">
                <summary class="flex items-center justify-between font-semibold text-flux-noir hover:text-flux-bleu transition-colors">
                    <span>{{ __('faq.q5') }}</span>
                    <x-icon name="chevron-down" class="w-5 h-5 text-flux-bleu transition-transform group-open:rotate-180" />
                </summary>
                <p class="text-flux-noir/70 leading-relaxed mt-4">
                    {{ __('faq.a5') }}
                </p>
            </details>
        </div>
    </div>

    <!-- Propriétaires & Hôteliers -->
    <div class="mb-16">
        <p class="text-flux-violet text-sm font-medium uppercase tracking-widest mb-2">{{ __('faq.pour_professionnels') }}</p>
        <h2 class="font-display text-3xl text-flux-noir mb-8">{{ __('faq.questions_pros') }}</h2>
        
        <div class="space-y-5">
            <!-- FAQ Item 6 -->
            <details class="border border-flux-noir/10 rounded-lg p-6 cursor-pointer group">
                <summary class="flex items-center justify-between font-semibold text-flux-noir hover:text-flux-bleu transition-colors">
                    <span>{{ __('faq.q6') }}</span>
                    <x-icon name="chevron-down" class="w-5 h-5 text-flux-violet transition-transform group-open:rotate-180" />
                </summary>
                <p class="text-flux-noir/70 leading-relaxed mt-4">
                    {{ __('faq.a6') }}
                </p>
            </details>

            <!-- FAQ Item 7 -->
            <details class="border border-flux-noir/10 rounded-lg p-6 cursor-pointer group">
                <summary class="flex items-center justify-between font-semibold text-flux-noir hover:text-flux-bleu transition-colors">
                    <span>{{ __('faq.q7') }}</span>
                    <x-icon name="chevron-down" class="w-5 h-5 text-flux-violet transition-transform group-open:rotate-180" />
                </summary>
                <p class="text-flux-noir/70 leading-relaxed mt-4">
                    {{ __('faq.a7') }}
                </p>
            </details>

            <!-- FAQ Item 8 -->
            <details class="border border-flux-noir/10 rounded-lg p-6 cursor-pointer group">
                <summary class="flex items-center justify-between font-semibold text-flux-noir hover:text-flux-bleu transition-colors">
                    <span>{{ __('faq.q8') }}</span>
                    <x-icon name="chevron-down" class="w-5 h-5 text-flux-violet transition-transform group-open:rotate-180" />
                </summary>
                <p class="text-flux-noir/70 leading-relaxed mt-4">
                    {{ __('faq.a8') }}
                </p>
            </details>

            <!-- FAQ Item 9 -->
            <details class="border border-flux-noir/10 rounded-lg p-6 cursor-pointer group">
                <summary class="flex items-center justify-between font-semibold text-flux-noir hover:text-flux-bleu transition-colors">
                    <span>{{ __('faq.q9') }}</span>
                    <x-icon name="chevron-down" class="w-5 h-5 text-flux-violet transition-transform group-open:rotate-180" />
                </summary>
                <p class="text-flux-noir/70 leading-relaxed mt-4">
                    {{ __('faq.a9') }}
                </p>
            </details>

            <!-- FAQ Item 10 -->
            <details class="border border-flux-noir/10 rounded-lg p-6 cursor-pointer group">
                <summary class="flex items-center justify-between font-semibold text-flux-noir hover:text-flux-bleu transition-colors">
                    <span>{{ __('faq.q10') }}</span>
                    <x-icon name="chevron-down" class="w-5 h-5 text-flux-violet transition-transform group-open:rotate-180" />
                </summary>
                <p class="text-flux-noir/70 leading-relaxed mt-4">
                    {{ __('faq.a10') }}
                </p>
            </details>
        </div>
    </div>

    <!-- Compte & Sécurité -->
    <div>
        <p class="text-flux-or text-sm font-medium uppercase tracking-widest mb-2">{{ __('faq.compte_securite') }}</p>
        <h2 class="font-display text-3xl text-flux-noir mb-8">{{ __('faq.gestion_compte') }}</h2>
        
        <div class="space-y-5">
            <!-- FAQ Item 11 -->
            <details class="border border-flux-noir/10 rounded-lg p-6 cursor-pointer group">
                <summary class="flex items-center justify-between font-semibold text-flux-noir hover:text-flux-bleu transition-colors">
                    <span>{{ __('faq.q11') }}</span>
                    <x-icon name="chevron-down" class="w-5 h-5 text-flux-or transition-transform group-open:rotate-180" />
                </summary>
                <p class="text-flux-noir/70 leading-relaxed mt-4">
                    {{ __('faq.a11') }}
                </p>
            </details>

            <!-- FAQ Item 12 -->
            <details class="border border-flux-noir/10 rounded-lg p-6 cursor-pointer group">
                <summary class="flex items-center justify-between font-semibold text-flux-noir hover:text-flux-bleu transition-colors">
                    <span>{{ __('faq.q12') }}</span>
                    <x-icon name="chevron-down" class="w-5 h-5 text-flux-or transition-transform group-open:rotate-180" />
                </summary>
                <p class="text-flux-noir/70 leading-relaxed mt-4">
                    {{ __('faq.a12') }}
                </p>
            </details>

            <!-- FAQ Item 13 -->
            <details class="border border-flux-noir/10 rounded-lg p-6 cursor-pointer group">
                <summary class="flex items-center justify-between font-semibold text-flux-noir hover:text-flux-bleu transition-colors">
                    <span>{{ __('faq.q13') }}</span>
                    <x-icon name="chevron-down" class="w-5 h-5 text-flux-or transition-transform group-open:rotate-180" />
                </summary>
                <p class="text-flux-noir/70 leading-relaxed mt-4">
                    {{ __('faq.a13') }}
                </p>
            </details>

            <!-- FAQ Item 14 -->
            <details class="border border-flux-noir/10 rounded-lg p-6 cursor-pointer group">
                <summary class="flex items-center justify-between font-semibold text-flux-noir hover:text-flux-bleu transition-colors">
                    <span>{{ __('faq.q14') }}</span>
                    <x-icon name="chevron-down" class="w-5 h-5 text-flux-or transition-transform group-open:rotate-180" />
                </summary>
                <p class="text-flux-noir/70 leading-relaxed mt-4">
                    {{ __('faq.a14') }}
                </p>
            </details>
        </div>
    </div>
</section>

<!-- Contact Support Section -->
<section class="bg-flux-bleu/5 border-y border-flux-noir/10 py-16 sm:py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <p class="text-flux-bleu text-sm font-medium uppercase tracking-widest mb-3">{{ __('faq.besoin_aide_sup') }}</p>
        <h2 class="font-display text-2xl sm:text-3xl text-flux-noir mb-6">{{ __('faq.contactez_support') }}</h2>
        <p class="text-flux-noir/70 mb-8 leading-relaxed">
            {{ __('faq.pas_trouve_reponse') }}
        </p>
        <a href="{{ route('contact') }}" class="inline-block bg-flux-bleu text-white px-6 py-3 rounded-lg font-semibold hover:bg-flux-bleu/90 transition-colors">
            {{ __('faq.nous_contacter') }}
        </a>
    </div>
</section>

<style>
    details > summary::-webkit-details-marker {
        display: none;
    }
</style>
@endsection
