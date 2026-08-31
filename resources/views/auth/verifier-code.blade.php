@extends('layouts.app')
@section('titre', __('pages.verify_titre'))

@section('contenu')
<div class="min-h-[70vh] flex items-center justify-center px-4 py-16">
    <div class="w-full max-w-sm text-center">
        <span class="inline-flex w-12 h-12 rounded-full bg-flux-bleu items-center justify-center mb-4">
            <x-icon name="mail" class="w-6 h-6 text-flux-or" />
        </span>
        <h1 class="font-display text-2xl text-flux-noir mb-2">{{ __('auth.verify_email') }}</h1>
        <p class="text-flux-noir/50 text-sm mb-8">
            {{ __('auth.verify_code_prefix') }} <strong>{{ $email }}</strong> {{ __('auth.verify_code_suffix') }}
        </p>

        <form action="{{ route('register.verifier.store') }}" method="POST" class="bg-white border border-black/10 rounded-2xl p-6 space-y-4">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <input type="text" name="code" required maxlength="6" inputmode="numeric" placeholder="000000"
                   class="w-full text-center text-2xl tracking-[0.5em] font-display border border-black/10 rounded-lg px-3 py-3 outline-none focus:border-flux-bleu">
            <button type="submit" class="w-full bg-flux-or hover:bg-flux-or-vif text-flux-noir font-semibold py-3 rounded-lg transition-colors">
                {{ __('auth.verify') }}
            </button>
        </form>

        <form action="{{ route('register.renvoyer-code') }}" method="POST" class="mt-4">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <button class="text-sm text-flux-bleu font-medium hover:underline">{{ __('auth.resend_code') }}</button>
        </form>
    </div>
</div>
@endsection
