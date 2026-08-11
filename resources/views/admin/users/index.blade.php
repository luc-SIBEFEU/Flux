@extends('layouts.dashboard')
@php($espaceRole = 'admin')
@section('titre_page', 'Clients & hôteliers')
@section('titre', 'Utilisateurs — Admin')

@section('contenu')

<form method="GET" class="flex flex-col sm:flex-row gap-3 mb-6">
    <div class="flex-1 flex items-center gap-2 border border-black/10 rounded-lg px-3 py-2.5 bg-white">
        <x-icon name="search" class="w-4 h-4 text-flux-noir/40" />
        <input type="text" name="recherche" value="{{ request('recherche') }}" placeholder="Rechercher par nom ou e-mail..." class="w-full outline-none text-sm">
    </div>
    <select name="role" class="border border-black/10 rounded-lg px-3 py-2.5 text-sm bg-white">
        <option value="">Tous les rôles</option>
        <option value="client" {{ request('role')=='client'?'selected':'' }}>Clients</option>
        <option value="hotelier" {{ request('role')=='hotelier'?'selected':'' }}>Hôteliers</option>
        <option value="bailleur" {{ request('role')=='bailleur'?'selected':'' }}>Bailleurs</option>
    </select>
    <select name="statut_validation" class="border border-black/10 rounded-lg px-3 py-2.5 text-sm bg-white">
        <option value="">Toute validation</option>
        <option value="en_attente" {{ request('statut_validation')=='en_attente'?'selected':'' }}>En attente</option>
        <option value="valide" {{ request('statut_validation')=='valide'?'selected':'' }}>Validés</option>
        <option value="rejete" {{ request('statut_validation')=='rejete'?'selected':'' }}>Rejetés</option>
    </select>
    <button class="bg-flux-bleu text-white text-sm font-medium px-5 py-2.5 rounded-lg">Filtrer</button>
</form>

<div class="bg-white border border-black/10 rounded-2xl overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-flux-brume text-flux-noir/50 text-xs uppercase">
            <tr>
                <th class="text-left px-5 py-3">Nom</th>
                <th class="text-left px-5 py-3 hidden sm:table-cell">E-mail</th>
                <th class="text-left px-5 py-3">Rôle</th>
                <th class="text-left px-5 py-3">Statut</th>
                <th class="text-right px-5 py-3">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-black/5">
            @foreach($users as $user)
                <tr>
                    <td class="px-5 py-3 font-medium">{{ $user->nom }}</td>
                    <td class="px-5 py-3 text-flux-noir/60 hidden sm:table-cell">{{ $user->email }}</td>
                    <td class="px-5 py-3 capitalize">{{ $user->role }}</td>
                    <td class="px-5 py-3">
                        <span class="text-xs px-2.5 py-1 rounded-full {{ $user->actif ? 'bg-flux-bleu-pale text-flux-bleu' : 'bg-red-50 text-red-500' }}">
                            {{ $user->actif ? 'Actif' : 'Désactivé' }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-right whitespace-nowrap">
                        <form action="{{ route('admin.users.toggle', $user) }}" method="POST" class="inline">
                            @csrf
                            <button class="text-flux-bleu text-xs font-medium mr-3">{{ $user->actif ? 'Désactiver' : 'Réactiver' }}</button>
                        </form>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer ce compte ?')">
                            @csrf @method('DELETE')
                            <button class="text-red-500 text-xs font-medium">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-8">{{ $users->links() }}</div>
@endsection
