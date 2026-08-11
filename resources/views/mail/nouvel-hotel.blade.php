@component('mail::message')
# Nouvel hôtel à valider

L'hôtelier **{{ $hotel->hotelier->nom }}** vient de soumettre un nouvel hôtel.

@component('mail::panel')
**Nom :** {{ $hotel->nom }}<br>
**Ville :** {{ $hotel->ville }}<br>
**Étoiles :** {{ $hotel->nombre_etoiles }}
@endcomponent

@component('mail::button', ['url' => route('admin.hotels.index')])
Examiner les hôtels en attente
@endcomponent

Merci,<br>
{{ config('app.name') }}
@endcomponent
