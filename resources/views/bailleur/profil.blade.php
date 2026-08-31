@extends('layouts.dashboard')
@php($espaceRole = 'bailleur')
@section('titre_page', __('profil.mon_profil'))
@section('titre', __('profil.titre_bailleur'))

@section('contenu')

<div class="max-w-xl space-y-6">
    <form action="{{ route('bailleur.profil.update') }}" method="POST" enctype="multipart/form-data" class="bg-white border border-black/10 rounded-2xl p-6 space-y-5">
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
                   class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-violet">
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="text-xs font-medium text-flux-noir/50">{{ __('form.email') }}</label>
                <input type="email" name="email" required value="{{ old('email', $user->email) }}"
                       class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-violet">
            </div>
            <div>
                <label class="text-xs font-medium text-flux-noir/50">{{ __('form.telephone') }}</label>
                <input type="tel" name="telephone" value="{{ old('telephone', $user->telephone) }}"
                       class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-violet">
            </div>
        </div>

        <hr class="border-black/5">

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="text-xs font-medium text-flux-noir/50">{{ __('form.nouveau_mdp') }}</label>
                <input type="password" name="password" class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-violet">
            </div>
            <div>
                <label class="text-xs font-medium text-flux-noir/50">{{ __('form.confirmation') }}</label>
                <input type="password" name="password_confirmation" class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-violet">
            </div>
        </div>

        <button type="submit" class="inline-flex items-center gap-2 bg-flux-violet text-white font-semibold px-6 py-3 rounded-lg">
            {{ __('form.enregistrer') }}
        </button>
    </form>

    <div class="bg-white border border-black/10 rounded-2xl p-6">
        <h3 class="font-medium mb-4">{{ __('profil.contacts_paiement_bailleur') }}</h3>
        <div class="space-y-2 mb-4">
            @foreach($user->bailleurContactsPaiement as $contact)
                <div class="flex items-center justify-between text-sm bg-flux-brume rounded-lg px-3 py-2">
                    <span><strong>{{ $contact->type === 'mtn_momo' ? 'MTN MoMo' : 'Orange Money' }}</strong> — {{ $contact->numero }}</span>
                    <form action="{{ route('bailleur.contacts-paiement.destroy', $contact) }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="text-red-500"><x-icon name="trash" class="w-4 h-4" /></button>
                    </form>
                </div>
            @endforeach
        </div>
        <form action="{{ route('bailleur.contacts-paiement.store') }}" method="POST" class="flex gap-2">
            @csrf
            <select name="type" class="border border-black/10 rounded-lg px-3 py-2 text-sm">
                <option value="mtn_momo">MTN MoMo</option>
                <option value="orange_money">Orange Money</option>
            </select>
            <input type="text" name="numero" required placeholder="{{ __('form.numero') }}" class="flex-1 border border-black/10 rounded-lg px-3 py-2 text-sm">
            <button class="bg-flux-violet text-white text-sm font-medium px-4 py-2 rounded-lg">{{ __('common.ajouter') }}</button>
        </form>
    </div>
</div>
@endsection
