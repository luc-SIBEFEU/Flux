@extends('layouts.app')
@section('titre', 'Connexion — Flux')

@section('contenu')
<div class="min-h-[70vh] flex items-center justify-center px-4 py-16">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <span class="inline-flex w-12 h-12 rounded-full bg-flux-bleu items-center justify-center mb-3">
                <x-icon name="sparkles" class="w-6 h-6 text-flux-or" />
            </span>
            <h1 class="font-display text-3xl text-flux-noir">Content de vous revoir</h1>
            <p class="text-flux-noir/50 text-sm mt-1">Connectez-vous à votre compte Flux</p>
        </div>

        <form action="{{ route('login') }}" method="POST" class="bg-white border border-black/10 rounded-2xl p-6 space-y-4">
            @csrf
            <div>
                <label class="text-xs font-medium text-flux-noir/50">Adresse e-mail</label>
                <div class="flex items-center gap-2 mt-1 border border-black/10 rounded-lg px-3 py-2.5">
                    <x-icon name="mail" class="w-4 h-4 text-flux-bleu shrink-0" />
                    <input type="email" name="email" required value="{{ old('email') }}" class="w-full outline-none text-sm" placeholder="vous@exemple.com">
                </div>
            </div>
            <div>
                <label class="text-xs font-medium text-flux-noir/50">Mot de passe</label>
                <input type="password" name="password" required class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
            </div>
            <label class="flex items-center gap-2 text-sm text-flux-noir/60">
                <input type="checkbox" name="remember" class="rounded"> Se souvenir de moi
            </label>
            <button type="submit" class="w-full bg-flux-bleu hover:bg-flux-bleu-vif text-white font-semibold py-3 rounded-lg transition-colors">
                Se connecter
            </button>
        </form>

        <p class="text-center text-sm text-flux-noir/50 mt-6">
            Pas encore de compte ?
            <a href="{{ route('register') }}" class="text-flux-bleu font-medium hover:underline">Créer un compte</a>
        </p>
    </div>
</div>
@endsection
