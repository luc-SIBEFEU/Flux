@component('mail::message')
# Séjour terminé

Le séjour de **{{ $reservation->client->nom }}** à l'hôtel **{{ $reservation->hotel->nom }}** vient de se terminer.

@component('mail::panel')
**Chambre :** {{ $reservation->categorieChambre->nom }}<br>
**Période :** {{ $reservation->date_arrivee->format('d/m/Y') }} → {{ $reservation->date_depart->format('d/m/Y') }}<br>
**Montant :** {{ number_format($reservation->prix_total, 0, ',', ' ') }} FCFA
@endcomponent

@component('mail::button', ['url' => route('hotelier.reservations.index')])
Voir mes réservations
@endcomponent

Merci,<br>
{{ config('app.name') }}
@endcomponent
