@extends('layouts.hotelier')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Mon tableau de bord</h1>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-violet-700">
            <p class="text-xs text-gray-500 uppercase">Mes hôtels</p>
            <p class="text-2xl font-bold text-gray-900">{{ $nbHotels }}</p>
        </div>
        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-blue-600">
            <p class="text-xs text-gray-500 uppercase">Réservations</p>
            <p class="text-2xl font-bold text-gray-900">{{ $nbReservations }}</p>
        </div>
        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-amber-400">
            <p class="text-xs text-gray-500 uppercase">En attente</p>
            <p class="text-2xl font-bold text-gray-900">{{ $nbEnAttente }}</p>
        </div>
        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-gray-900">
            <p class="text-xs text-gray-500 uppercase">Revenus confirmés</p>
            <p class="text-2xl font-bold text-gray-900">{{ number_format($revenus, 0) }} FCFA</p>
        </div>
    </div>

    <div class="flex gap-3">
        <a href="{{ route('hotelier.hotels.index') }}" class="px-5 py-3 bg-violet-700 text-white rounded-lg font-semibold">Gérer mes hôtels</a>
        <a href="{{ route('hotelier.reservations.index') }}" class="px-5 py-3 border-2 border-violet-700 text-violet-700 rounded-lg font-semibold">Voir les réservations</a>
    </div>
</div>
@endsection
