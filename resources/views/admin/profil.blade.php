@extends('layouts.dashboard')
@php($espaceRole = 'admin')
@section('titre_page', 'Mon profil')
@section('titre', 'Profil — Admin')

@section('contenu')

<div class="max-w-xl space-y-6">
    <form action="{{ route('admin.profil.update') }}" method="POST" class="bg-white border border-black/10 rounded-2xl p-6 space-y-5">
        @csrf @method('PUT')

        <div>
            <label class="text-xs font-medium text-flux-noir/50">Nom complet</label>
            <input type="text" name="nom" required value="{{ old('nom', $user->nom) }}"
                   class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-or">
        </div>
        <div>
            <label class="text-xs font-medium text-flux-noir/50">Téléphone</label>
            <input type="tel" name="telephone" value="{{ old('telephone', $user->telephone) }}"
                   class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-or">
        </div>

        <hr class="border-black/5">

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="text-xs font-medium text-flux-noir/50">Nouveau mot de passe</label>
                <input type="password" name="password" class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-or">
            </div>
            <div>
                <label class="text-xs font-medium text-flux-noir/50">Confirmation</label>
                <input type="password" name="password_confirmation" class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-or">
            </div>
        </div>

        <button type="submit" class="inline-flex items-center gap-2 bg-flux-or text-flux-noir font-semibold px-6 py-3 rounded-lg">
            Enregistrer
        </button>
    </form>

    <div class="bg-white border border-black/10 rounded-2xl p-6">
        <h3 class="font-medium mb-1">Contacts de paiement (réception des forfaits pro)</h3>
        <p class="text-xs text-flux-noir/50 mb-4">Numéros MTN MoMo / Orange Money sur lesquels les hôteliers/bailleurs paient leur forfait pro.</p>
        <div class="space-y-2 mb-4">
            @foreach ($user->adminContactsPaiement as $contact)
                <div class="flex items-center justify-between text-sm bg-flux-brume rounded-lg px-3 py-2">
                    <span><strong>{{ $contact->type === 'mtn_momo' ? 'MTN MoMo' : 'Orange Money' }}</strong> — {{ $contact->numero }}</span>
                    <form action="{{ route('admin.contacts-paiement.destroy', $contact) }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="text-red-500"><x-icon name="trash" class="w-4 h-4" /></button>
                    </form>
                </div>
            @endforeach
        </div>
        <form action="{{ route('admin.contacts-paiement.store') }}" method="POST" class="flex gap-2">
            @csrf
            <select name="type" class="border border-black/10 rounded-lg px-3 py-2 text-sm">
                <option value="mtn_momo">MTN MoMo</option>
                <option value="orange_money">Orange Money</option>
            </select>
            <input type="text" name="numero" required placeholder="Numéro" class="flex-1 border border-black/10 rounded-lg px-3 py-2 text-sm">
            <button class="bg-flux-or text-flux-noir text-sm font-medium px-4 py-2 rounded-lg">Ajouter</button>
        </form>
    </div>
</div>
@endsection
