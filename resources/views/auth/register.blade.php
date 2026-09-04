@extends('layouts.app')
@section('titre', __('pages.register_titre'))

@section('contenu')
<div class="min-h-[70vh] flex items-center justify-center px-4 py-16">
    <div class="w-full max-w-lg">
        <div class="text-center mb-8">
            <span class="inline-flex w-12 h-12 rounded-full bg-flux-or items-center justify-center mb-3">
                <x-icon name="sparkles" class="w-6 h-6 text-flux-noir" />
            </span>
            <h1 class="font-display text-3xl text-flux-noir">{{ __('auth.creer_compte') }}</h1>
            <p class="text-flux-noir/50 text-sm mt-1">{{ __('auth.register_description') }}</p>
        </div>

        <form action="{{ route('register') }}" method="POST" x-data="{ role: '{{ $type }}' }" class="bg-white border border-black/10 rounded-2xl p-6 space-y-4">
            @csrf

            <div>
                <label class="text-xs font-medium text-flux-noir/50 mb-2 block">{{ __('auth.register_as') }}</label>
                <div class="grid grid-cols-3 gap-2">
                    <label>
                        <input type="radio" name="role" value="client" x-model="role" class="peer sr-only">
                        <div class="text-center py-2.5 rounded-lg border border-black/10 peer-checked:bg-flux-bleu peer-checked:text-white peer-checked:border-flux-bleu cursor-pointer text-sm">{{ __('auth.role_client') }}</div>
                    </label>
                    <label>
                        <input type="radio" name="role" value="hotelier" x-model="role" class="peer sr-only">
                        <div class="text-center py-2.5 rounded-lg border border-black/10 peer-checked:bg-flux-bleu peer-checked:text-white peer-checked:border-flux-bleu cursor-pointer text-sm">{{ __('auth.role_hotelier') }}</div>
                    </label>
                    <label>
                        <input type="radio" name="role" value="bailleur" x-model="role" class="peer sr-only">
                        <div class="text-center py-2.5 rounded-lg border border-black/10 peer-checked:bg-flux-violet peer-checked:text-white peer-checked:border-flux-violet cursor-pointer text-sm">{{ __('auth.role_bailleur') }}</div>
                    </label>
                </div>
            </div>

            <div>
                <label class="text-xs font-medium text-flux-noir/50">{{ __('auth.nom') }}</label>
                <input type="text" name="nom" required value="{{ old('nom') }}" class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="text-xs font-medium text-flux-noir/50">{{ __('auth.email') }}</label>
                    <input type="email" name="email" required value="{{ old('email') }}" class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
                </div>
                <div>
                    <label class="text-xs font-medium text-flux-noir/50">{{ __('auth.telephone') }}</label>
                    <input type="tel" name="telephone" value="{{ old('telephone') }}" class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
                </div>
            </div>
            <div>
                <label class="text-xs font-medium text-flux-noir/50">{{ __('auth.genre') }}</label>
                <select name="genre" class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none">
                    <option value="">{{ __('auth.gender_not_specified') }}</option>
                    <option value="homme">{{ __('auth.gender_male') }}</option>
                    <option value="femme">{{ __('auth.gender_female') }}</option>
                </select>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="text-xs font-medium text-flux-noir/50">{{ __('auth.mot_de_passe') }}</label>
                    <input type="password" name="password" required class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
                </div>
                <div>
                    <label class="text-xs font-medium text-flux-noir/50">{{ __('auth.password_confirmation') }}</label>
                    <input type="password" name="password_confirmation" required class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
                </div>
            </div>

            <button type="submit" class="w-full bg-flux-or hover:bg-flux-or-vif text-flux-noir font-semibold py-3 rounded-lg transition-colors">
                {{ __('auth.create_my_account') }}
            </button>
            <p class="text-center text-sm text-flux-noir/70">{{ __('auth.accept_terms_intro') }} 
                <a href="{{ route('conditions-utilisation') }}" class="hover:underline font-medium text-flux-bleu">{{ __('pages.conditions_titre') }}</a>
                {{ __('auth.accept_terms_middle') }}
                <a href="{{ route('politique-confidentialite') }}" class="hover:underline font-medium text-flux-bleu">{{ __('pages.confidentialite_titre') }}</a>
            </p>
        </form>

        <p class="text-center text-sm text-flux-noir/50 mt-6">
            {{ __('auth.deja_compte') }} <a href="{{ route('login') }}" class="text-flux-bleu font-medium hover:underline">{{ __('auth.se_connecter') }}</a>
        </p>
    </div>
</div>
@endsection
