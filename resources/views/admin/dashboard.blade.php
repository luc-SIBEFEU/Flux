@extends('layouts.admin')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Tableau de bord</h1>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-violet-700">
            <p class="text-xs text-gray-500 uppercase">Clients</p>
            <p class="text-2xl font-bold text-gray-900">{{ $nbClients }}</p>
        </div>
        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-amber-400">
            <p class="text-xs text-gray-500 uppercase">Hôteliers</p>
            <p class="text-2xl font-bold text-gray-900">{{ $nbHoteliers }}</p>
        </div>
        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-blue-600">
            <p class="text-xs text-gray-500 uppercase">Hôtels</p>
            <p class="text-2xl font-bold text-gray-900">{{ $nbHotels }}</p>
            <p class="text-xs text-amber-600 mt-1">{{ $nbHotelsEnAttente }} en attente de validation</p>
        </div>
        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-gray-900">
            <p class="text-xs text-gray-500 uppercase">Réservations</p>
            <p class="text-2xl font-bold text-gray-900">{{ $nbReservations }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-gradient-to-br from-violet-700 to-violet-900 text-white rounded-xl shadow p-6">
            <p class="text-sm opacity-80 uppercase">Chiffre d'affaires total (réservations confirmées)</p>
            <p class="text-3xl font-bold mt-2">{{ number_format($chiffreAffaires, 0) }} FCFA</p>
            <a href="{{ route('admin.reports') }}" class="text-amber-300 text-sm hover:underline mt-3 inline-block">Voir le rapport détaillé →</a>
        </div>
        <div class="bg-white rounded-xl shadow p-6">
            <p class="text-sm text-gray-500 uppercase">Avis en attente de modération</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $nbAvisEnAttente }}</p>
            <a href="{{ route('admin.reviews.index') }}" class="text-violet-700 text-sm hover:underline mt-3 inline-block">Gérer les avis →</a>
        </div>
    </div>
</div>
@endsection
