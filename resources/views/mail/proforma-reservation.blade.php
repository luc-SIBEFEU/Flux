@component('mail::message')
# {{ __('mail.merci_sejour_titre') }}

{{ __('mail.bonjour', ['nom' => $reservation->client->nom]) }},

{{ __('mail.sejour_termine_corps', ['hotel' => $reservation->hotel->nom]) }}

@component('mail::panel')
**{{ __('mail.periode') }} :** {{ $reservation->date_arrivee->format('d/m/Y') }} → {{ $reservation->date_depart->format('d/m/Y') }}<br>
**{{ __('mail.montant_total') }} :** {{ number_format($reservation->prix_total, 0, ',', ' ') }} FCFA
@endcomponent

{{ __('mail.merci_confiance') }},<br>
{{ __('mail.equipe') }} {{ config('app.name') }}
@endcomponent
