<x-mail::message>
<div style="text-align:center; margin-bottom: 20px;">
@if($reservation->hotel->logoUrl())
<img src="{{ $reservation->hotel->logoUrl() }}" alt="{{ $reservation->hotel->nom }}" style="height:60px;">
@endif
</div>

# Facture pro-forma

Bonjour **{{ $reservation->client->nom }}**,

Merci pour votre réservation. Voici le récapitulatif de votre séjour, en attente de confirmation du paiement.

<x-mail::table>
| Détail | Information |
|:-------|:------------|
| N° de réservation | #{{ $reservation->id }} |
| Hôtel | {{ $reservation->hotel->nom }} ({{ $reservation->hotel->ville }}) |
| Catégorie de chambre | {{ $reservation->roomCategory->nom }} |
| Arrivée | {{ $reservation->date_debut->format('d/m/Y') }} |
| Départ | {{ $reservation->date_fin->format('d/m/Y') }} |
| Nombre de nuits | {{ $reservation->nombreNuits() }} |
| Adultes | {{ $reservation->nombre_adultes }} |
| Enfants | {{ $reservation->nombre_enfants }} |
| Téléphone | {{ $reservation->telephone_client }} |
</x-mail::table>

<x-mail::panel>
**Total à payer : {{ number_format($reservation->prix_total, 0) }} FCFA**
</x-mail::panel>

Ce document est une facture pro-forma et ne constitue pas une preuve de paiement.
Votre réservation sera définitivement confirmée dès validation du paiement mobile money.

<x-mail::button :url="route('client.reservations.index')">
Voir mes réservations
</x-mail::button>

Merci de votre confiance,<br>
{{ config('app.name') }}
</x-mail::message>
