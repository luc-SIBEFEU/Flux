@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-10">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Mon profil</h1>

    <div class="bg-white rounded-xl shadow border border-gray-100 p-6 mb-6">
        <div class="flex items-center gap-4 mb-4">
            <img src="{{ auth()->user()->avatarUrl() }}" class="w-16 h-16 rounded-full object-cover">
            <div>
                <p class="font-semibold text-gray-900">{{ auth()->user()->nom }}</p>
                <p class="text-sm text-gray-500">Client</p>
            </div>
        </div>

        <form method="POST" action="{{ route('client.profile.update') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="text-xs font-semibold text-gray-500 uppercase">Nom</label>
                <input type="text" name="nom" value="{{ old('nom', auth()->user()->nom) }}" class="w-full mt-1 rounded-lg border-gray-300">
                @error('nom') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-500 uppercase">Email</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="w-full mt-1 rounded-lg border-gray-300">
                @error('email') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-500 uppercase">Téléphone</label>
                <input type="text" name="telephone" value="{{ old('telephone', auth()->user()->telephone) }}" class="w-full mt-1 rounded-lg border-gray-300">
                @error('telephone') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-500 uppercase">Genre</label>
                <select name="genre" class="w-full mt-1 rounded-lg border-gray-300">
                    <option value="homme" {{ old('genre', auth()->user()->genre) === 'homme' ? 'selected' : '' }}>Homme</option>
                    <option value="femme" {{ old('genre', auth()->user()->genre) === 'femme' ? 'selected' : '' }}>Femme</option>
                </select>
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-500 uppercase">Avatar</label>
                <input type="file" name="avatar" class="w-full mt-1">
            </div>
            <button type="submit" class="px-4 py-2 bg-violet-700 text-white rounded-lg font-semibold">Enregistrer</button>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow border border-gray-100 p-6">
        <h2 class="font-semibold text-gray-900 mb-4">Changer le mot de passe</h2>
        <form method="POST" action="{{ route('client.profile.password') }}" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="text-xs font-semibold text-gray-500 uppercase">Nouveau mot de passe</label>
                <input type="password" name="nouveau_mot_de_passe" class="w-full mt-1 rounded-lg border-gray-300">
                @error('nouveau_mot_de_passe') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-500 uppercase">Confirmer</label>
                <input type="password" name="nouveau_mot_de_passe_confirmation" class="w-full mt-1 rounded-lg border-gray-300">
            </div>
            <button type="submit" class="px-4 py-2 bg-gray-900 text-white rounded-lg font-semibold">Modifier le mot de passe</button>
        </form>
    </div>
</div>
@endsection
