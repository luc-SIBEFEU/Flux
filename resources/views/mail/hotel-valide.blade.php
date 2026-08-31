@component('mail::message')
# {{ __('mail.hotel_valide_titre') }} ✅

{{ __('mail.bonjour', ['nom' => $hotel->hotelier->nom]) }},

{{ __('mail.hotel_valide_corps', ['nom' => $hotel->nom]) }}

@component('mail::button', ['url' => route('hotels.show', $hotel)])
{{ __('mail.voir_fiche_hotel') }}
@endcomponent

{{ __('mail.merci') }},<br>
{{ config('app.name') }}
@endcomponent
