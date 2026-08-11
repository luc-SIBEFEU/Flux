@extends('layouts.dashboard')
@php $espaceRole = 'admin'; @endphp
@section('titre_page', 'Toutes les réservations')
@section('titre', 'Réservations — Consultation admin')

@section('contenu')

<p class="text-xs text-flux-noir/40 mb-4 flex items-center gap-1.5"><x-icon name="cog" class="w-3.5 h-3.5" /> Lecture seule.</p>

<form method="GET" class="flex gap-3 mb-6">
    <select name="statut" class="border border-black/10 rounded-lg px-3 py-2.5 text-sm bg-white">
        <option value="">Tous les statuts</option>
        <option value="en_attente" {{ request('statut')=='en_attente'?'selected':'' }}>En attente</option>
        <option value="confirmee" {{ request('statut')=='confirmee'?'selected':'' }}>Confirmées</option>
        <option value="annulee" {{ request('statut')=='annulee'?'selected':'' }}>Annulées</option>
        <option value="terminee" {{ request('statut')=='terminee'?'selected':'' }}>Terminées</option>
    </select>
    <button class="bg-flux-bleu text-white text-sm font-medium px-5 py-2.5 rounded-lg">Filtrer</button>
</form>

<div class="bg-white border border-black/10 rounded-2xl overflow-x-auto">
    <table class="w-full text-sm min-w-[720px]">
        <thead class="bg-flux-brume text-flux-noir/50 text-xs uppercase">
            <tr>
                <th class="text-left px-5 py-3">Client</th>
                <th class="text-left px-5 py-3">Hôtel</th>
                <th class="text-left px-5 py-3">Période</th>
                <th class="text-left px-5 py-3">Prix</th>
                <th class="text-left px-5 py-3">Statut</th>
                <th class="text-right px-5 py-3">Détail</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-black/5">
            @foreach($reservations as $r)
                <tr>
                    <td class="px-5 py-3 font-medium">{{ $r->client->nom }}</td>
                    <td class="px-5 py-3 text-flux-noir/60">{{ $r->hotel->nom }}</td>
                    <td class="px-5 py-3 whitespace-nowrap">{{ $r->date_arrivee->format('d/m/y') }} → {{ $r->date_depart->format('d/m/y') }}</td>
                    <td class="px-5 py-3">{{ number_format($r->prix_total,0,',',' ') }} F</td>
                    <td class="px-5 py-3">
                        @php $badges = ['en_attente'=>'bg-flux-or/20 text-flux-or','confirmee'=>'bg-flux-bleu-pale text-flux-bleu','annulee'=>'bg-red-50 text-red-500','terminee'=>'bg-black/5 text-flux-noir/50']; @endphp
                        <span class="text-xs px-2.5 py-1 rounded-full font-medium {{ $badges[$r->statut] }}">{{ ucfirst(str_replace('_',' ',$r->statut)) }}</span>
                    </td>
                    <td class="px-5 py-3 text-right">
                        <a href="{{ route('admin.consultation.reservations.show', $r) }}" class="text-flux-bleu text-xs font-medium">Voir →</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-8">{{ $reservations->links() }}</div>
@endsection
