@extends('layouts.dashboard')
@php $espaceRole = 'hotelier'; @endphp
@section('titre_page', 'Réservations')
@section('titre', 'Réservations — Hôtelier')

@section('contenu')

<div class="flex gap-2 mb-6 overflow-x-auto carte-scroll">
    @foreach(['' => 'Toutes', 'en_attente'=>'En attente', 'confirmee'=>'Confirmées', 'annulee'=>'Annulées', 'terminee'=>'Terminées'] as $val=>$label)
        <a href="{{ route('hotelier.reservations.index', array_filter(['statut'=>$val])) }}"
           class="shrink-0 px-4 py-2 rounded-full text-sm font-medium border
                  {{ request('statut', '') === $val ? 'bg-flux-bleu text-white border-flux-bleu' : 'bg-white text-flux-noir/60 border-black/10' }}">
            {{ $label }}
        </a>
    @endforeach
</div>

<div class="bg-white border border-black/10 rounded-2xl overflow-x-auto">
    <table class="w-full text-sm min-w-[720px]">
        <thead class="bg-flux-brume text-flux-noir/50 text-xs uppercase">
            <tr>
                <th class="text-left px-5 py-3">Client</th>
                <th class="text-left px-5 py-3">Hôtel / Chambre</th>
                <th class="text-left px-5 py-3">Période</th>
                <th class="text-left px-5 py-3">Prix</th>
                <th class="text-left px-5 py-3">Statut</th>
                <th class="text-left px-5 py-3">Paiement</th>
                <th class="text-right px-5 py-3">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-black/5">
            @foreach($reservations as $r)
                <tr>
                    <td class="px-5 py-3">
                        <div class="font-medium">{{ $r->client->nom }}</div>
                        <div class="text-xs text-flux-noir/40">{{ $r->telephone_client }}</div>
                    </td>
                    <td class="px-5 py-3">{{ $r->hotel->nom }}<br><span class="text-xs text-flux-noir/40">{{ $r->categorieChambre->nom }}</span></td>
                    <td class="px-5 py-3 whitespace-nowrap">{{ $r->date_arrivee->format('d/m/y') }} → {{ $r->date_depart->format('d/m/y') }}</td>
                    <td class="px-5 py-3 font-medium text-flux-bleu">{{ number_format($r->prix_total,0,',',' ') }} F</td>
                    <td class="px-5 py-3">
                        @php $badges = ['en_attente'=>'bg-flux-or/20 text-flux-or','confirmee'=>'bg-flux-bleu-pale text-flux-bleu','annulee'=>'bg-red-50 text-red-500','terminee'=>'bg-black/5 text-flux-noir/50']; @endphp
                        <span class="text-xs px-2.5 py-1 rounded-full font-medium {{ $badges[$r->statut] ?? '' }}">{{ ucfirst(str_replace('_',' ',$r->statut)) }}</span>
                    </td>
                    <td class="px-5 py-3">
                        @php $badgesPaiement = ['en_attente'=>'bg-flux-or/20 text-flux-or','reussi'=>'bg-green-50 text-green-600','echoue'=>'bg-red-50 text-red-500','rembourse'=>'bg-black/5 text-flux-noir/50']; @endphp
                        <span class="text-xs px-2.5 py-1 rounded-full font-medium {{ $badgesPaiement[$r->statut_paiement] ?? '' }}">{{ ucfirst(str_replace('_',' ',$r->statut_paiement)) }}</span>
                    </td>
                    <td class="px-5 py-3 text-right whitespace-nowrap">
                        @if($r->statut === 'en_attente')
                            <form action="{{ route('hotelier.reservations.confirmer', $r) }}" method="POST" class="inline">
                                @csrf
                                <button class="text-flux-bleu text-xs font-medium mr-3">Confirmer</button>
                            </form>
                            <form action="{{ route('hotelier.reservations.annuler', $r) }}" method="POST" class="inline">
                                @csrf
                                <button class="text-red-500 text-xs font-medium">Annuler</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-8">{{ $reservations->links() }}</div>
@endsection
