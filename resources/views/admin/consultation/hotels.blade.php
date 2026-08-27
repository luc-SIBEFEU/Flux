@extends('layouts.dashboard')
@php $espaceRole = 'admin'; @endphp
@section('titre_page', 'Tous les hôtels')
@section('titre', 'Hôtels — Consultation admin')

@section('contenu')

<p class="text-xs text-flux-noir/40 mb-4 flex items-center gap-1.5"><x-icon name="cog" class="w-3.5 h-3.5" /> Lecture seule — l'admin consulte, seul l'hôtelier modifie.</p>

<form method="GET" class="flex flex-col sm:flex-row gap-3 mb-6">
    <div class="flex-1 flex items-center gap-2 border border-black/10 rounded-lg px-3 py-2.5 bg-white">
        <x-icon name="map-pin" class="w-4 h-4 text-flux-noir/40" />
        <input type="text" name="ville" value="{{ request('ville') }}" placeholder="Filtrer par ville..." class="w-full outline-none text-sm">
    </div>
    <select name="statut" class="border border-black/10 rounded-lg px-3 py-2.5 text-sm bg-white">
        <option value="">Tous les statuts</option>
        <option value="en_attente" {{ request('statut')=='en_attente'?'selected':'' }}>En attente</option>
        <option value="valide" {{ request('statut')=='valide'?'selected':'' }}>Validés</option>
        <option value="rejete" {{ request('statut')=='rejete'?'selected':'' }}>Rejetés</option>
    </select>
    <button class="bg-flux-bleu text-white text-sm font-medium px-5 py-2.5 rounded-lg">Filtrer</button>
</form>

<div class="bg-white border border-black/10 rounded-2xl overflow-x-auto">
    <table class="w-full text-sm min-w-[720px]">
        <thead class="bg-flux-brume text-flux-noir/50 text-xs uppercase">
            <tr>
                <th class="text-left px-5 py-3">Hôtel</th>
                <th class="text-left px-5 py-3">Hôtelier</th>
                <th class="text-left px-5 py-3">Ville</th>
                <th class="text-left px-5 py-3">Statut</th>
                <th class="text-right px-5 py-3">Détail</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-black/5">
            @foreach($hotels as $hotel)
                <tr>
                    <td class="px-5 py-3 font-medium">{{ $hotel->nom }}</td>
                    <td class="px-5 py-3 text-flux-noir/60">{{ $hotel->hotelier->nom }}</td>
                    <td class="px-5 py-3">{{ $hotel->ville }}</td>
                    <td class="px-5 py-3">
                        @php $badges = ['en_attente'=>'bg-flux-or/20 text-flux-or','valide'=>'bg-flux-bleu-pale text-flux-bleu','rejete'=>'bg-red-50 text-red-500']; @endphp
                        <span class="text-xs px-2.5 py-1 rounded-full font-medium {{ $badges[$hotel->statut] }}">{{ ucfirst(str_replace('_',' ',$hotel->statut)) }}</span>
                    </td>
                    <td class="px-5 py-3 text-right">
                        <a href="{{ route('admin.consultation.hotels.show', ['hotel'=>$hotel, 'action'=>$action='consultation']) }}" class="text-flux-bleu text-xs font-medium">Voir →</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-8">{{ $hotels->links() }}</div>
@endsection
