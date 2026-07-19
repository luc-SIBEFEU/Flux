@extends('layouts.hotelier')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Réservations reçues</h1>

    <div class="flex gap-2 mb-6">
        @foreach(['tout' => 'Toutes', 'en_attente' => 'En attente', 'confirmee' => 'Confirmées', 'annulee' => 'Annulées'] as $val => $label)
            <a href="{{ route('hotelier.reservations.index', ['statut' => $val]) }}"
               class="px-4 py-2 rounded-full text-sm font-medium {{ $statut === $val ? 'bg-violet-700 text-white' : 'bg-white text-gray-600 border' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="p-3 text-left">#</th>
                    <th class="p-3 text-left">Client</th>
                    <th class="p-3 text-left">Hôtel</th>
                    <th class="p-3 text-left">Chambre</th>
                    <th class="p-3 text-left">Période</th>
                    <th class="p-3 text-left">Personnes</th>
                    <th class="p-3 text-right">Prix</th>
                    <th class="p-3 text-left">Statut</th>
                    <th class="p-3 text-left">Paiement</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($reservations as $r)
                <tr>
                    <td class="p-3 text-gray-400">#{{ $r->id }}</td>
                    <td class="p-3 font-medium text-gray-900">{{ $r->client->nom }}</td>
                    <td class="p-3 text-gray-500">{{ $r->hotel->nom }}</td>
                    <td class="p-3 text-gray-500">{{ $r->roomCategory->nom }}</td>
                    <td class="p-3 text-gray-500">{{ $r->date_debut->format('d/m/Y') }} → {{ $r->date_fin->format('d/m/Y') }}</td>
                    <td class="p-3 text-gray-500">{{ $r->nombre_adultes }}A / {{ $r->nombre_enfants }}E</td>
                    <td class="p-3 text-right font-semibold text-violet-700">{{ number_format($r->prix_total, 0) }} FCFA</td>
                    <td class="p-3">
                        <span class="text-xs px-2 py-0.5 rounded-full
                            {{ $r->statut === 'confirmee' ? 'bg-green-100 text-green-700' : ($r->statut === 'annulee' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">
                            {{ ucfirst($r->statut) }}
                        </span>
                    </td>
                    <td class="p-3">
                        @if($r->payment && $r->payment->mode === 'manuel' && $r->statut === 'en_attente')
                            @if($r->payment->preuve_paiement)
                                <p class="text-xs text-gray-500 mb-1">Réf : {{ $r->payment->preuve_paiement }}</p>
                                <form method="POST" action="{{ route('hotelier.reservations.confirmer-paiement', $r) }}" onsubmit="return confirm('Confirmer la réception du paiement ?');">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="px-2 py-1 bg-green-600 text-white text-xs rounded-lg">Confirmer paiement</button>
                                </form>
                            @else
                                <span class="text-xs text-gray-400">En attente de la réf. client</span>
                            @endif
                        @elseif($r->payment)
                            <span class="text-xs text-gray-400">{{ ucfirst($r->payment->mode) }}</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="p-6 text-center text-gray-400">Aucune réservation.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $reservations->links() }}</div>
</div>
@endsection
