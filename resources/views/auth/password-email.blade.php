@extends('layouts.app')
@section('titre', 'Mot de passe oublié — Flux')

@section('contenu')
<div class="min-h-[70vh] flex items-center justify-center px-4 py-16">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <span class="inline-flex w-12 h-12 rounded-full bg-flux-bleu items-center justify-center mb-3">
                <x-icon name="mail" class="w-6 h-6 text-flux-or" />
            </span>
            <h1 class="font-display text-3xl text-flux-noir">Mot de passe oublié ?</h1>
            <p class="text-flux-noir/50 text-sm mt-1">Saisissez l'adresse e-mail de votre compte Flux.</p>
        </div>

        <form action="{{ route('password.email') }}" method="POST" class="bg-white border border-black/10 rounded-2xl p-6 space-y-4">
            @csrf
            <div>
                <label for="email" class="text-xs font-medium text-flux-noir/50">Adresse e-mail</label>
                <input id="email" type="email" name="email" required value="{{ old('email') }}" autofocus class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu" placeholder="vous@exemple.com">
            </div>
            <button type="submit" class="w-full bg-flux-bleu hover:bg-flux-bleu-vif text-white font-semibold py-3 rounded-lg transition-colors">Continuer</button>
        </form>

        <p class="text-center text-sm text-flux-noir/50 mt-6"><a href="{{ route('login') }}" class="text-flux-bleu font-medium hover:underline">Retour à la connexion</a></p>
    </div>
</div>
@endsection
