@extends('layouts.admin')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Rapports financiers</h1>

    <form method="GET" action="{{ route('admin.reports') }}" class="bg-white rounded-xl shadow border border-gray-100 p-5 flex flex-wrap items-end gap-4 mb-6">
        <div>
            <label class="text-xs font-semibold text-gray-500 uppercase">Du</label>
            <input type="date" name="date_debut" value="{{ $dateDebut }}" class="w-full mt-1 rounded-lg border-gray-300">
        </div>
        <div>
            <label class="text-xs font-semibold text-gray-500 uppercase">Au</label>
            <input type="date" name="date_fin" value="{{ $dateFin }}" class="w-full mt-1 rounded-lg border-gray-300">
        </div>
        <button type="submit" class="px-4 py-2 bg-violet-700 text-white rounded-lg font-semibold">Filtrer</button>
    </form>

    <div class="bg-gradient-to-br from-violet-700 to-violet-900 text-white rounded-xl shadow p-6 mb-8">
        <p class="text-sm opacity-80 uppercase">Total général (période sélectionnée)</p>
        <p class="text-3xl font-bold mt-2">{{ number_format($totalGeneral, 0) }} FCFA</p>
    </div>

    <h2 class="font-semibold text-gray-900 mb-3">Détail par hôtel</h2>
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="p-3 text-left">Hôtel</th>
                    <th class="p-3 text-left">Ville</th>
                    <th class="p-3 text-right">Réservations</th>
                    <th class="p-3 text-right">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($parHotel as $hotel)
                <tr>
                    <td class="p-3 font-medium text-gray-900">{{ $hotel->nom }}</td>
                    <td class="p-3 text-gray-500">{{ $hotel->ville }}</td>
                    <td class="p-3 text-right">{{ $hotel->nb_reservations }}</td>
                    <td class="p-3 text-right font-semibold text-violet-700">{{ number_format($hotel->total_confirme, 0) }} FCFA</td>
                </tr>
                @empty
                <tr><td colspan="4" class="p-6 text-center text-gray-400">Aucune donnée pour cette période.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
