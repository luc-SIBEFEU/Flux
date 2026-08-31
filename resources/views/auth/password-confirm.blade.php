@extends('layouts.app')
@section('titre', __('pages.password_confirm_titre'))

@section('contenu')
<div class="min-h-[70vh] flex items-center justify-center px-4 py-16">
    <div class="w-full max-w-lg">
        <div class="text-center mb-8">
            <span class="inline-flex w-12 h-12 rounded-full bg-flux-bleu items-center justify-center mb-3">
                <x-icon name="user" class="w-6 h-6 text-flux-or" />
            </span>
            <h1 class="font-display text-3xl text-flux-noir">{{ __('auth.confirm_identity') }}</h1>
            <p class="text-flux-noir/50 text-sm mt-1">{{ __('auth.confirm_identity_instruction') }}</p>
        </div>

        <form action="{{ route('password.reset') }}" method="POST" class="bg-white border border-black/10 rounded-2xl p-6 space-y-4">
            @csrf
            <div>
                <label for="email" class="text-xs font-medium text-flux-noir/50">{{ __('auth.email') }}</label>
                <input id="email" type="email" name="email" readonly value="{{ $user->email }}" class="mt-1 w-full bg-flux-brume border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none">
            </div>
            <div>
                <label for="nom" class="text-xs font-medium text-flux-noir/50">{{ __('auth.nom') }}</label>
                <input id="nom" type="text" name="nom" required value="{{ old('nom') }}" class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="genre" class="text-xs font-medium text-flux-noir/50">{{ __('auth.genre') }}</label>
                    <select id="genre" name="genre" required class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
                        <option value="">{{ __('auth.select') }}</option>
                        <option value="homme">{{ __('auth.gender_male') }}</option>
                        <option value="femme">{{ __('auth.gender_female') }}</option>
                        <option value="autre">{{ __('auth.gender_other') }}</option>
                    </select>
                </div>
                <div>
                    <label for="role" class="text-xs font-medium text-flux-noir/50">{{ __('auth.account_type') }}</label>
                    <select id="role" name="role" required class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
                        <option value="">{{ __('auth.select') }}</option>
                        <option value="client">{{ __('auth.role_client') }}</option>
                        <option value="hotelier">{{ __('auth.role_hotelier') }}</option>
                        <option value="bailleur">{{ __('auth.role_bailleur') }}</option>
                    </select>
                </div>
            </div>
            <div>
                <label for="telephone" class="text-xs font-medium text-flux-noir/50">{{ __('auth.telephone') }}</label>
                <input id="telephone" type="tel" name="telephone" required value="{{ old('telephone') }}" class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
            </div>
            <button type="submit" class="w-full bg-flux-or hover:bg-flux-or-vif text-flux-noir font-semibold py-3 rounded-lg transition-colors">{{ __('auth.receive_new_password') }}</button>
        </form>
    </div>
</div>
@endsection
