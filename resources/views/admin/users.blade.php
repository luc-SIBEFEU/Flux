@extends('layouts.admin')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Gestion des utilisateurs</h1>

    <div class="flex items-center justify-between mb-4">
        <div class="flex gap-2">
            <a href="{{ route('admin.users.index', ['role' => 'client']) }}" class="px-4 py-2 rounded-full text-sm font-medium {{ $role === 'client' ? 'bg-violet-700 text-white' : 'bg-white text-gray-600 border' }}">Clients</a>
            <a href="{{ route('admin.users.index', ['role' => 'hotelier']) }}" class="px-4 py-2 rounded-full text-sm font-medium {{ $role === 'hotelier' ? 'bg-violet-700 text-white' : 'bg-white text-gray-600 border' }}">Hôteliers</a>
        </div>
        <form method="GET" action="{{ route('admin.users.index') }}">
            <input type="hidden" name="role" value="{{ $role }}">
            <input type="text" name="recherche" value="{{ $recherche }}" placeholder="Rechercher..." class="rounded-lg border-gray-300 text-sm">
        </form>
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="p-3 text-left">Nom</th>
                    <th class="p-3 text-left">Email</th>
                    <th class="p-3 text-left">Téléphone</th>
                    <th class="p-3 text-left">Statut</th>
                    <th class="p-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($users as $user)
                <tr>
                    <td class="p-3 font-medium text-gray-900">{{ $user->nom }}</td>
                    <td class="p-3 text-gray-500">{{ $user->email }}</td>
                    <td class="p-3 text-gray-500">{{ $user->telephone }}</td>
                    <td class="p-3">
                        <span class="text-xs px-2 py-0.5 rounded-full {{ $user->actif ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $user->actif ? 'Actif' : 'Désactivé' }}
                        </span>
                    </td>
                    <td class="p-3 text-right space-x-2">
                        <form method="POST" action="{{ route('admin.users.toggle', $user) }}" class="inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="text-violet-700 hover:underline">{{ $user->actif ? 'Désactiver' : 'Activer' }}</button>
                        </form>
                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline" onsubmit="return confirm('Supprimer cet utilisateur ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $users->links() }}</div>
</div>
@endsection
