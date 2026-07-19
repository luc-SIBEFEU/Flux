@extends('layouts.guest')

@section('content')
<div class="max-w-md mx-auto px-4 py-16">
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
        <h1 class="text-2xl font-bold text-center text-gray-900 mb-1">Connexion</h1>
        <p class="text-center text-gray-500 text-sm mb-6">Client, hôtelier ou administrateur</p>

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
            <div>
                <label class="text-xs font-semibold text-gray-500 uppercase">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full mt-1 rounded-lg border-gray-300 focus:ring-violet-600 focus:border-violet-600">
                @error('email') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-500 uppercase">Mot de passe</label>
                <input type="password" name="password" class="w-full mt-1 rounded-lg border-gray-300 focus:ring-violet-600 focus:border-violet-600">
                @error('password') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
            </div>
            <label class="flex items-center gap-2 text-sm text-gray-600">
                <input type="checkbox" name="remember"> Se souvenir de moi
            </label>
            <button type="submit" class="w-full py-3 bg-violet-700 hover:bg-violet-800 text-white font-semibold rounded-lg transition">
                Se connecter
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-6">
            Pas encore de compte ?
            <a href="{{ route('register') }}" class="text-violet-700 font-semibold hover:underline">S'inscrire</a>
        </p>
    </div>
</div>
@endsection
