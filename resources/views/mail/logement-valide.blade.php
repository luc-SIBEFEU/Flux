@component('mail::message')
# Logement validé ✅

Bonjour {{ $logement->bailleur->nom }},

Votre logement ({{ ucfirst($logement->type) }}, {{ $logement->quartier }}) a été validé et est maintenant visible sur le site.

@component('mail::button', ['url' => route('logements.show', $logement)])
Voir l'annonce
@endcomponent

Merci,<br>
{{ config('app.name') }}
@endcomponent
