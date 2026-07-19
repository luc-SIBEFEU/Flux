@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-10">
    <h1 class="text-2xl font-bold text-gray-900 mb-1">Confirmer votre réservation</h1>
    <p class="text-gray-500 mb-6">{{ $hotel->nom }} — {{ $chambre->nom }}</p>

    <form method="POST" action="{{ route('reservations.store') }}" class="bg-white rounded-xl shadow border border-gray-100 p-6 space-y-5">
        @csrf
        <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">
        <input type="hidden" name="room_category_id" value="{{ $chambre->id }}">

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="text-xs font-semibold text-gray-500 uppercase">Arrivée</label>
                <input type="date" name="date_debut" value="{{ old('date_debut', $dateDebut) }}" class="w-full mt-1 rounded-lg border-gray-300 focus:ring-violet-600 focus:border-violet-600">
                @error('date_debut') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-500 uppercase">Départ</label>
                <input type="date" name="date_fin" value="{{ old('date_fin', $dateFin) }}" class="w-full mt-1 rounded-lg border-gray-300 focus:ring-violet-600 focus:border-violet-600">
                @error('date_fin') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="text-xs font-semibold text-gray-500 uppercase">Adultes</label>
                <input type="number" min="1" max="{{ $chambre->capacite_adultes }}" name="adultes" value="{{ old('adultes', $adultes) }}" class="w-full mt-1 rounded-lg border-gray-300 focus:ring-violet-600 focus:border-violet-600">
                @error('adultes') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-500 uppercase">Enfants</label>
                <input type="number" min="0" max="{{ $chambre->capacite_enfants }}" name="enfants" value="{{ old('enfants', $enfants) }}" class="w-full mt-1 rounded-lg border-gray-300 focus:ring-violet-600 focus:border-violet-600">
            </div>
        </div>

        <div>
            <label class="text-xs font-semibold text-gray-500 uppercase">Numéro de téléphone (client)</label>
            <input type="text" name="telephone_client" value="{{ old('telephone_client', auth()->user()->telephone) }}" class="w-full mt-1 rounded-lg border-gray-300 focus:ring-violet-600 focus:border-violet-600">
            @error('telephone_client') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
        </div>

        <hr>

        <div>
            <label class="text-xs font-semibold text-gray-500 uppercase mb-2 block">Méthode de paiement</label>
            <div class="grid grid-cols-2 gap-3">
                <label class="border rounded-lg p-3 flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="methode_paiement" value="mtn_momo" {{ old('methode_paiement', 'mtn_momo') === 'mtn_momo' ? 'checked' : '' }}> 🟡 MTN MoMo
                </label>
                <label class="border rounded-lg p-3 flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="methode_paiement" value="orange_money" {{ old('methode_paiement') === 'orange_money' ? 'checked' : '' }}> 🟠 Orange Money
                </label>
            </div>
            @error('methode_paiement') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="text-xs font-semibold text-gray-500 uppercase">Numéro pour le paiement</label>
            <input type="text" name="telephone_paiement" value="{{ old('telephone_paiement', auth()->user()->telephone) }}" placeholder="ex: 6XX XXX XXX" class="w-full mt-1 rounded-lg border-gray-300 focus:ring-violet-600 focus:border-violet-600">
            @error('telephone_paiement') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center justify-between bg-gray-50 rounded-lg p-4">
            <span class="text-gray-600">Total à payer</span>
            <span class="text-2xl font-bold text-violet-700">{{ number_format($prixTotal ?? 0, 0) }} FCFA</span>
        </div>

        <button type="submit" class="w-full py-3 bg-violet-700 hover:bg-violet-800 text-white font-semibold rounded-lg transition">
            Valider et payer
        </button>
    </form>
</div>
@endsection
