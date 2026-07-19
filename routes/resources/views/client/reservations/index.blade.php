@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Mes réservations</h1>

    <div class="flex gap-2 mb-6">
        @foreach(['tout' => 'Toutes', 'en_attente' => 'En attente', 'confirmee' => 'Confirmées', 'annulee' => 'Annulées'] as $val => $label)
            <a href="{{ route('client.reservations.index', ['onglet' => $val]) }}"
               class="px-4 py-2 rounded-full text-sm font-medium {{ $onglet === $val ? 'bg-violet-700 text-white' : 'bg-white text-gray-600 border' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    <div class="space-y-4">
        @forelse($reservations as $r)
        <div class="bg-white rounded-xl shadow border border-gray-100 p-5 flex flex-col md:flex-row md:items-center justify-between gap-3">
            <div>
                <h3 class="font-semibold text-gray-900">{{ $r->hotel->nom }} — {{ $r->roomCategory->nom }}</h3>
                <p class="text-sm text-gray-500">{{ $r->date_debut->format('d/m/Y') }} → {{ $r->date_fin->format('d/m/Y') }} · {{ $r->nombre_adultes }} adultes, {{ $r->nombre_enfants }} enfants</p>
            </div>
            <div class="flex items-center gap-4">
                <span class="font-semibold text-violet-700">{{ number_format($r->prix_total, 0) }} FCFA</span>
                <span class="text-xs px-2 py-0.5 rounded-full
                    {{ $r->statut === 'confirmee' ? 'bg-green-100 text-green-700' : ($r->statut === 'annulee' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">
                    {{ ucfirst($r->statut) }}
                </span>

                @if($r->statut === 'en_attente' && $r->payment)
                    @if($r->payment->mode === 'manuel')
                        <a href="{{ route('paiement.instructions', $r->payment) }}" class="text-violet-700 text-sm hover:underline">
                            {{ $r->payment->preuve_paiement ? 'Voir les instructions' : 'Finaliser le paiement' }}
                        </a>
                    @else
                        <form method="POST" action="{{ route('paiement.verifier', $r->payment) }}">
                            @csrf
                            <button type="submit" class="text-violet-700 text-sm hover:underline">Vérifier mon paiement</button>
                        </form>
                    @endif
                @endif

                @if($r->statut === 'en_attente')
                    <form method="POST" action="{{ route('client.reservations.annuler', $r) }}" onsubmit="return confirm('Annuler cette réservation ?');">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="text-red-600 text-sm hover:underline">Annuler</button>
                    </form>
                @endif
            </div>
        </div>
        @empty
        <p class="text-gray-400 text-center py-16">Aucune réservation dans cette catégorie.</p>
        @endforelse
    </div>

    <div class="mt-6">{{ $reservations->links() }}</div>
</div>
@endsection
