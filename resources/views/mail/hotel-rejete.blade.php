@component('mail::message')
# Hôtel non validé

Bonjour {{ $hotel->hotelier->nom }},

Votre hôtel **{{ $hotel->nom }}** n'a pas été validé.

@if($hotel->motif_rejet)
@component('mail::panel')
{{ $hotel->motif_rejet }}
@endcomponent
@endif

Vous pouvez le modifier et le soumettre à nouveau.

@component('mail::button', ['url' => route('hotelier.hotels.edit', $hotel)])
Modifier mon hôtel
@endcomponent

Merci,<br>
{{ config('app.name') }}
@endcomponent
