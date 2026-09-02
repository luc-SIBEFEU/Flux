@extends('layouts.dashboard')
@php $espaceRole = 'admin'; @endphp
@section('titre_page', __('consultation.detail_reservation'))
@section('titre', __('reservation.reservation_singulier') . ' — ' . __('consultation.consultation_admin'))

@section('contenu')

<a href="{{ route('admin.consultation.reservations') }}" class="text-sm text-flux-noir/50 hover:text-flux-bleu">← {{ __('reservation.retour_aux_reservations') }}</a>

<div class="bg-white border border-black/10 rounded-2xl p-6 max-w-xl mt-6 space-y-3">
    <h2 class="font-display text-2xl">{{ $reservation->hotel->nom }}</h2>
    <p class="text-sm text-flux-noir/50">{{ $reservation->categorieChambre->nom }}</p>
    <p class="text-sm text-flux-noir/50">{{ $reservation->date_arrivee->format('d/m/Y') }} → {{ $reservation->date_depart->format('d/m/Y') }}</p>
    <p class="text-sm"><strong>{{ __('common.client') }} :</strong> {{ $reservation->client->nom }} — {{ $reservation->telephone_client }}</p>
    <p class="font-display text-xl text-flux-bleu">{{ number_format($reservation->prix_total,0,',',' ') }} FCFA</p>

    @if($reservation->proforma_pdf)
        <a href="{{ asset('storage/'.$reservation->proforma_pdf) }}" target="_blank"
           class="inline-flex items-center gap-2 bg-flux-bleu text-white text-sm font-medium px-4 py-2.5 rounded-lg">
            <x-icon name="camera" class="w-4 h-4" /> {{ __('consultation.telecharger_proforma') }}
        </a>
    @endif
</div>
@endsection
