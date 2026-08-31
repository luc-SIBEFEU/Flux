@component('mail::message')
# {{ __('mail.nouvel_hotel_titre') }}

{{ __('mail.nouvel_hotel_corps', ['hotelier' => $hotel->hotelier->nom]) }}

@component('mail::panel')
**{{ __('common.nom') }} :** {{ $hotel->nom }}<br>
**{{ __('common.ville') }} :** {{ $hotel->ville }}<br>
**{{ __('mail.etoiles') }} :** {{ $hotel->nombre_etoiles }}
@endcomponent

@component('mail::button', ['url' => route('admin.hotels.index')])
{{ __('mail.examiner_hotels_attente') }}
@endcomponent

{{ __('mail.merci') }},<br>
{{ config('app.name') }}
@endcomponent
