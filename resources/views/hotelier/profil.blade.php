@extends('layouts.dashboard')
@php($espaceRole = 'hotelier')
@section('titre_page', 'Mon profil')
@section('titre', 'Profil — Hôtelier')

@section('contenu')

<form action="{{ route('hotelier.profil.update') }}" method="POST" enctype="multipart/form-data" class="bg-white border border-black/10 rounded-2xl p-6 max-w-xl space-y-5">
    @csrf @method('PUT')

    <div class="flex items-center gap-4">
        <img src="{{ $user->avatar ? asset('storage/'.$user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->nom) }}"
             class="w-16 h-16 rounded-full object-cover">
        <div>
            <label class="text-xs font-medium text-flux-noir/50">Photo de profil</label>
            <input type="file" name="avatar" accept="image/*" class="block mt-1 text-sm">
        </div>
    </div>

    <div>
        <label class="text-xs font-medium text-flux-noir/50">Nom complet</label>
        <input type="text" name="nom" required value="{{ old('nom', $user->nom) }}"
               class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
    </div>
    <div>
        <label class="text-xs font-medium text-flux-noir/50">E-mail</label>
        <div class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">{{ $user->email }}</div><span style="color: #e91b1b; font-size: 0.75rem;">E-mail non modifiable</span>

        <input type="email" name="email" required value="{{ old('email', $user->email) }}"
               class="hidden mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
    </div>
    <div>
        <label class="text-xs font-medium text-flux-noir/50">Genre</label>
        <select name="genre" class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none">
            <option value="">Ne pas préciser</option>
            <option value="homme" {{ $user->genre=='homme'?'selected':'' }}>Homme</option>
            <option value="femme" {{ $user->genre=='femme'?'selected':'' }}>Femme</option>
        </select>
    </div>

    <hr class="border-black/5">

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="text-xs font-medium text-flux-noir/50">Nouveau mot de passe</label>
            <input type="password" name="password" class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
        </div>
        <div>
            <label class="text-xs font-medium text-flux-noir/50">Confirmation</label>
            <input type="password" name="password_confirmation" class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
        </div>
    </div>

    <button type="submit" class="inline-flex items-center gap-2 bg-flux-bleu text-white font-semibold px-6 py-3 rounded-lg">
        Enregistrer
    </button>
</form>
@endsection
