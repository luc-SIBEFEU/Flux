@component('mail::message')
# {{ __('mail.hotel_non_valide_titre') }}

{{ __('mail.bonjour', ['nom' => $hotel->hotelier->nom]) }},

{{ __('mail.hotel_non_valide_corps', ['nom' => $hotel->nom]) }}

@if($hotel->motif_rejet)
@component('mail::panel')
{{ $hotel->motif_rejet }}
@endcomponent
@endif

{{ __('mail.modifier_soumettre') }}

@component('mail::button', ['url' => route('hotelier.hotels.edit', $hotel)])
{{ __('mail.modifier_mon_hotel') }}
@endcomponent

{{ __('mail.merci') }},<br>
{{ config('app.name') }}
@endcomponent
