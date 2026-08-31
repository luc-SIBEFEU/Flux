@extends('layouts.dashboard')
@php $espaceRole = 'client'; @endphp
@section('titre_page', __('profil.mon_profil'))
@section('titre', __('profil.titre_client'))

@section('contenu')

<form action="{{ route('client.profil.update') }}" method="POST" enctype="multipart/form-data" class="bg-white border border-black/10 rounded-2xl p-6 max-w-xl space-y-5">
    @csrf @method('PUT')

    <div class="flex items-center gap-4">
        <img src="{{ $user->avatar ? asset('storage/'.$user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->nom) }}"
             class="w-16 h-16 rounded-full object-cover">
        <div>
            <label class="text-xs font-medium text-flux-noir/50">{{ __('form.photo_profil') }}</label>
            <input type="file" name="avatar" accept="image/*" class="block mt-1 text-sm">
        </div>
    </div>

    <div>
        <label class="text-xs font-medium text-flux-noir/50">{{ __('form.nom_complet') }}</label>
        <input type="text" name="nom" required value="{{ old('nom', $user->nom) }}"
               class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="text-xs font-medium text-flux-noir/50">{{ __('form.email') }}</label>
            <input type="email" name="email" required value="{{ old('email', $user->email) }}"
                   class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
        </div>
        <div>
            <label class="text-xs font-medium text-flux-noir/50">{{ __('form.telephone') }}</label>
            <input type="tel" name="telephone" value="{{ old('telephone', $user->telephone) }}"
                   class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
        </div>
    </div>
    <div>
        <label class="text-xs font-medium text-flux-noir/50">{{ __('form.genre') }}</label>
        <select name="genre" class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none">
            <option value="">{{ __('form.ne_pas_preciser') }}</option>
            <option value="homme" {{ $user->genre=='homme'?'selected':'' }}>{{ __('form.homme') }}</option>
            <option value="femme" {{ $user->genre=='femme'?'selected':'' }}>{{ __('form.femme') }}</option>
        </select>
    </div>

    <hr class="border-black/5">

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="text-xs font-medium text-flux-noir/50">{{ __('form.nouveau_mdp') }}</label>
            <input type="password" name="password" class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
        </div>
        <div>
            <label class="text-xs font-medium text-flux-noir/50">{{ __('form.confirmation') }}</label>
            <input type="password" name="password_confirmation" class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
        </div>
    </div>

    <button type="submit" class="inline-flex items-center gap-2 bg-flux-bleu text-white font-semibold px-6 py-3 rounded-lg">
        {{ __('form.enregistrer') }}
    </button>
</form>
@endsection
