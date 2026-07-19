@extends('layouts.admin')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Actualités</h1>
        <a href="{{ route('admin.actualites.create') }}" class="px-4 py-2 bg-violet-700 text-white rounded-lg font-semibold">+ Nouvelle actualité</a>
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="p-3 text-left">Nom</th>
                    <th class="p-3 text-left">Période</th>
                    <th class="p-3 text-left">Auteur</th>
                    <th class="p-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($actualites as $a)
                <tr>
                    <td class="p-3 font-medium text-gray-900">{{ $a->nom }}</td>
                    <td class="p-3 text-gray-500">{{ $a->date_debut->format('d/m/Y') }} → {{ $a->date_fin->format('d/m/Y') }}</td>
                    <td class="p-3 text-gray-500">{{ $a->auteur->nom }}</td>
                    <td class="p-3 text-right space-x-2">
                        <a href="{{ route('admin.actualites.edit', $a) }}" class="text-violet-700 hover:underline">Modifier</a>
                        <form method="POST" action="{{ route('admin.actualites.destroy', $a) }}" class="inline" onsubmit="return confirm('Supprimer cette actualité ?');">
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
    <div class="mt-4">{{ $actualites->links() }}</div>
</div>
@endsection
