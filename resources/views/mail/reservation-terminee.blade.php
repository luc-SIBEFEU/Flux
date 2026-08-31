@component('mail::message')
# {{ __('mail.sejour_termine_titre') }}

{{ __('mail.sejour_termine_hotelier_corps', ['client' => $reservation->client->nom, 'hotel' => $reservation->hotel->nom]) }}

@component('mail::panel')
**{{ __('mail.chambre') }} :** {{ $reservation->categorieChambre->nom }}<br>
**{{ __('mail.periode') }} :** {{ $reservation->date_arrivee->format('d/m/Y') }} → {{ $reservation->date_depart->format('d/m/Y') }}<br>
**{{ __('mail.montant') }} :** {{ number_format($reservation->prix_total, 0, ',', ' ') }} FCFA
@endcomponent

@component('mail::button', ['url' => route('hotelier.reservations.index')])
{{ __('mail.voir_mes_reservations') }}
@endcomponent

{{ __('mail.merci') }},<br>
{{ config('app.name') }}
@endcomponent
