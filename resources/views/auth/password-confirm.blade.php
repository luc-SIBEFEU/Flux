@extends('layouts.app')
@section('titre', 'Confirmer votre identité — Flux')

@section('contenu')
<div class="min-h-[70vh] flex items-center justify-center px-4 py-16">
    <div class="w-full max-w-lg">
        <div class="text-center mb-8">
            <span class="inline-flex w-12 h-12 rounded-full bg-flux-bleu items-center justify-center mb-3">
                <x-icon name="user" class="w-6 h-6 text-flux-or" />
            </span>
            <h1 class="font-display text-3xl text-flux-noir">Confirmez votre identité</h1>
            <p class="text-flux-noir/50 text-sm mt-1">Vérifiez les informations de votre compte pour recevoir un nouveau mot de passe.</p>
        </div>

        <form action="{{ route('password.reset') }}" method="POST" class="bg-white border border-black/10 rounded-2xl p-6 space-y-4">
            @csrf
            <div>
                <label for="email" class="text-xs font-medium text-flux-noir/50">Adresse e-mail</label>
                <input id="email" type="email" name="email" readonly value="{{ $user->email }}" class="mt-1 w-full bg-flux-brume border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none">
            </div>
            <div>
                <label for="nom" class="text-xs font-medium text-flux-noir/50">Nom complet</label>
                <input id="nom" type="text" name="nom" required value="{{ old('nom') }}" class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="genre" class="text-xs font-medium text-flux-noir/50">Sexe</label>
                    <select id="genre" name="genre" required class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
                        <option value="">Sélectionner</option>
                        <option value="homme">Homme</option>
                        <option value="femme">Femme</option>
                        <option value="autre">Autre</option>
                    </select>
                </div>
                <div>
                    <label for="role" class="text-xs font-medium text-flux-noir/50">Type de compte</label>
                    <select id="role" name="role" required class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
                        <option value="">Sélectionner</option>
                        <option value="client">Client</option>
                        <option value="hotelier">Hôtelier</option>
                        <option value="bailleur">Bailleur</option>
                    </select>
                </div>
            </div>
            <div>
                <label for="telephone" class="text-xs font-medium text-flux-noir/50">Téléphone</label>
                <input id="telephone" type="tel" name="telephone" required value="{{ old('telephone') }}" class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
            </div>
            <button type="submit" class="w-full bg-flux-or hover:bg-flux-or-vif text-flux-noir font-semibold py-3 rounded-lg transition-colors">Recevoir mon nouveau mot de passe</button>
        </form>
    </div>
</div>
@endsection
