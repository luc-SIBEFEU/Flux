@component('mail::message')
# Merci pour votre séjour !

Bonjour {{ $reservation->client->nom }},

Votre séjour à l'hôtel **{{ $reservation->hotel->nom }}** est terminé. Vous trouverez votre pro-forma en pièce jointe.

@component('mail::panel')
**Période :** {{ $reservation->date_arrivee->format('d/m/Y') }} → {{ $reservation->date_depart->format('d/m/Y') }}<br>
**Montant total :** {{ number_format($reservation->prix_total, 0, ',', ' ') }} FCFA
@endcomponent

Merci de votre confiance,<br>
L'équipe {{ config('app.name') }}
@endcomponent
