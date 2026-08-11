@component('mail::message')
# Hôtel validé ✅

Bonjour {{ $hotel->hotelier->nom }},

Votre hôtel **{{ $hotel->nom }}** a été validé et est maintenant visible sur le site.

@component('mail::button', ['url' => route('hotels.show', $hotel)])
Voir la fiche hôtel
@endcomponent

Merci,<br>
{{ config('app.name') }}
@endcomponent
