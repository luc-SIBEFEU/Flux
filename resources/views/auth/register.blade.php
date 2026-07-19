@extends('layouts.guest')

@section('content')
<div class="max-w-md mx-auto px-4 py-16">
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
        <h1 class="text-2xl font-bold text-center text-gray-900 mb-6">Créer un compte</h1>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf
            <div class="grid grid-cols-2 gap-3">
                <label class="border rounded-lg p-3 flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="role" value="client" {{ old('role', 'client') === 'client' ? 'checked' : '' }}> Client
                </label>
                <label class="border rounded-lg p-3 flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="role" value="hotelier" {{ old('role') === 'hotelier' ? 'checked' : '' }}> Hôtelier
                </label>
            </div>
            @error('role') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror

            <div>
                <label class="text-xs font-semibold text-gray-500 uppercase">Nom complet</label>
                <input type="text" name="nom" value="{{ old('nom') }}" class="w-full mt-1 rounded-lg border-gray-300 focus:ring-violet-600 focus:border-violet-600">
                @error('nom') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-500 uppercase">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full mt-1 rounded-lg border-gray-300 focus:ring-violet-600 focus:border-violet-600">
                @error('email') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-500 uppercase">Téléphone</label>
                <input type="text" name="telephone" value="{{ old('telephone') }}" class="w-full mt-1 rounded-lg border-gray-300 focus:ring-violet-600 focus:border-violet-600">
                @error('telephone') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-500 uppercase">Genre</label>
                <select name="genre" class="w-full mt-1 rounded-lg border-gray-300 focus:ring-violet-600 focus:border-violet-600">
                    <option value="homme" {{ old('genre') === 'homme' ? 'selected' : '' }}>Homme</option>
                    <option value="femme" {{ old('genre') === 'femme' ? 'selected' : '' }}>Femme</option>
                </select>
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-500 uppercase">Mot de passe</label>
                <input type="password" name="password" class="w-full mt-1 rounded-lg border-gray-300 focus:ring-violet-600 focus:border-violet-600">
                @error('password') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-500 uppercase">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" class="w-full mt-1 rounded-lg border-gray-300 focus:ring-violet-600 focus:border-violet-600">
            </div>

            <button type="submit" class="w-full py-3 bg-violet-700 hover:bg-violet-800 text-white font-semibold rounded-lg transition">
                S'inscrire
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-6">
            Déjà un compte ?
            <a href="{{ route('login') }}" class="text-violet-700 font-semibold hover:underline">Se connecter</a>
        </p>
    </div>
</div>
@endsection
