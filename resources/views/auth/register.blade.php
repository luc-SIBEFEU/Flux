@extends('layouts.app')
@section('titre', 'Créer un compte — Flux')

@section('contenu')
<div class="min-h-[70vh] flex items-center justify-center px-4 py-16">
    <div class="w-full max-w-lg">
        <div class="text-center mb-8">
            <span class="inline-flex w-12 h-12 rounded-full bg-flux-or items-center justify-center mb-3">
                <x-icon name="sparkles" class="w-6 h-6 text-flux-noir" />
            </span>
            <h1 class="font-display text-3xl text-flux-noir">Créer un compte</h1>
            <p class="text-flux-noir/50 text-sm mt-1">Rejoignez Flux en quelques secondes</p>
        </div>

        <form action="{{ route('register') }}" method="POST" x-data="{ role: '{{ $type }}' }" class="bg-white border border-black/10 rounded-2xl p-6 space-y-4">
            @csrf

            <div>
                <label class="text-xs font-medium text-flux-noir/50 mb-2 block">Je m'inscris en tant que</label>
                <div class="grid grid-cols-3 gap-2">
                    <label>
                        <input type="radio" name="role" value="client" x-model="role" class="peer sr-only">
                        <div class="text-center py-2.5 rounded-lg border border-black/10 peer-checked:bg-flux-bleu peer-checked:text-white peer-checked:border-flux-bleu cursor-pointer text-sm">Client</div>
                    </label>
                    <label>
                        <input type="radio" name="role" value="hotelier" x-model="role" class="peer sr-only">
                        <div class="text-center py-2.5 rounded-lg border border-black/10 peer-checked:bg-flux-bleu peer-checked:text-white peer-checked:border-flux-bleu cursor-pointer text-sm">Hôtelier</div>
                    </label>
                    <label>
                        <input type="radio" name="role" value="bailleur" x-model="role" class="peer sr-only">
                        <div class="text-center py-2.5 rounded-lg border border-black/10 peer-checked:bg-flux-violet peer-checked:text-white peer-checked:border-flux-violet cursor-pointer text-sm">Bailleur</div>
                    </label>
                </div>
            </div>

            <div>
                <label class="text-xs font-medium text-flux-noir/50">Nom complet</label>
                <input type="text" name="nom" required value="{{ old('nom') }}" class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="text-xs font-medium text-flux-noir/50">E-mail</label>
                    <input type="email" name="email" required value="{{ old('email') }}" class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
                </div>
                <div>
                    <label class="text-xs font-medium text-flux-noir/50">Téléphone</label>
                    <input type="tel" name="telephone" value="{{ old('telephone') }}" class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
                </div>
            </div>
            <div>
                <label class="text-xs font-medium text-flux-noir/50">Genre</label>
                <select name="genre" class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none">
                    <option value="">Ne pas préciser</option>
                    <option value="homme">Homme</option>
                    <option value="femme">Femme</option>
                </select>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="text-xs font-medium text-flux-noir/50">Mot de passe</label>
                    <input type="password" name="password" required class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
                </div>
                <div>
                    <label class="text-xs font-medium text-flux-noir/50">Confirmation</label>
                    <input type="password" name="password_confirmation" required class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
                </div>
            </div>

            <button type="submit" class="w-full bg-flux-or hover:bg-flux-or-vif text-flux-noir font-semibold py-3 rounded-lg transition-colors">
                Créer mon compte
            </button>
            <p class="text-center text-sm text-flux-noir/70">En envoyant ce formulaire, vous acceptez nos 
                <a href="{{ route('conditions-utilisation') }}" class="hover:underline font-medium text-flux-bleu">conditions d'utilisation</a>
                et notre
                <a href="{{ route('politique-confidentialite') }}" class="hover:underline font-medium text-flux-bleu">Politique de confidentialité</a>
            </p>
        </form>

        <p class="text-center text-sm text-flux-noir/50 mt-6">
            Déjà inscrit ? <a href="{{ route('login') }}" class="text-flux-bleu font-medium hover:underline">Se connecter</a>
        </p>
    </div>
</div>
@endsection
