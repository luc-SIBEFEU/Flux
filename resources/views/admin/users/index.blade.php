@extends('layouts.dashboard')
@php($espaceRole = 'admin')
@section('titre_page', __('sidebar.clients_hoteliers_bailleurs'))
@section('titre', __('admin_users.utilisateurs') . ' — ' . __('sidebar.espace_admin'))

@section('contenu')

<form method="GET" class="flex flex-col sm:flex-row gap-3 mb-6">
    <div class="flex-1 flex items-center gap-2 border border-black/10 rounded-lg px-3 py-2.5 bg-white">
        <x-icon name="search" class="w-4 h-4 text-flux-noir/40" />
        <input type="text" name="recherche" value="{{ request('recherche') }}" placeholder="{{ __('admin_users.rechercher_nom_email') }}" class="w-full outline-none text-sm">
    </div>
    <select name="role" class="border border-black/10 rounded-lg px-3 py-2.5 text-sm bg-white">
        <option value="">{{ __('admin_users.tous_les_roles') }}</option>
        <option value="client" {{ request('role')=='client'?'selected':'' }}>{{ __('admin_users.role_clients') }}</option>
        <option value="hotelier" {{ request('role')=='hotelier'?'selected':'' }}>{{ __('dashboard_stats.hoteliers') }}</option>
        <option value="bailleur" {{ request('role')=='bailleur'?'selected':'' }}>{{ __('dashboard_stats.bailleurs') }}</option>
    </select>
    <select name="statut_validation" class="border border-black/10 rounded-lg px-3 py-2.5 text-sm bg-white">
        <option value="">{{ __('logement.toute_validation') }}</option>
        <option value="en_attente" {{ request('statut_validation')=='en_attente'?'selected':'' }}>{{ __('common.statut_en_attente') }}</option>
        <option value="valide" {{ request('statut_validation')=='valide'?'selected':'' }}>{{ __('common.statut_valides') }}</option>
        <option value="rejete" {{ request('statut_validation')=='rejete'?'selected':'' }}>{{ __('common.statut_rejetes') }}</option>
    </select>
    <button class="bg-flux-bleu text-white text-sm font-medium px-5 py-2.5 rounded-lg">{{ __('common.filtrer') }}</button>
</form>

<div class="bg-white border border-black/10 rounded-2xl overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-flux-brume text-flux-noir/50 text-xs uppercase">
            <tr>
                <th class="text-left px-5 py-3">{{ __('common.nom') }}</th>
                <th class="text-left px-5 py-3 hidden sm:table-cell">{{ __('form.email') }}</th>
                <th class="text-left px-5 py-3">{{ __('mail.role') }}</th>
                <th class="text-left px-5 py-3">{{ __('common.statut') }}</th>
                <th class="text-right px-5 py-3">{{ __('common.actions') }}</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-black/5">
            @foreach($users as $user)
                <tr>
                    <td class="px-5 py-3 font-medium">{{ $user->nom }}</td>
                    <td class="px-5 py-3 text-flux-noir/60 hidden sm:table-cell">{{ $user->email }}</td>
                    <td class="px-5 py-3">{{ __('admin_users.role_' . $user->role) }}</td>
                    <td class="px-5 py-3">
                        <span class="text-xs px-2.5 py-1 rounded-full {{ $user->actif ? 'bg-flux-bleu-pale text-flux-bleu' : 'bg-red-50 text-red-500' }}">
                            {{ $user->actif ? __('admin_users.actif') : __('admin_users.desactive') }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-right whitespace-nowrap">
                        <form action="{{ route('admin.users.toggle', $user) }}" method="POST" class="inline">
                            @csrf
                            <button class="text-flux-bleu text-xs font-medium mr-3">{{ $user->actif ? __('admin_users.desactiver') : __('admin_users.reactiver') }}</button>
                        </form>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('admin_users.confirmer_suppression_compte') }}')">
                            @csrf @method('DELETE')
                            <button class="text-red-500 text-xs font-medium">{{ __('common.supprimer') }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-8">{{ $users->links() }}</div>
@endsection
