@component('mail::message')
# Logement non validé

Bonjour {{ $logement->bailleur->nom }},

Votre logement ({{ ucfirst($logement->type) }}, {{ $logement->quartier }}) n'a pas été validé.

@if($logement->motif_rejet)
@component('mail::panel')
{{ $logement->motif_rejet }}
@endcomponent
@endif

Vous pouvez le modifier et le soumettre à nouveau depuis votre espace.

@component('mail::button', ['url' => route('bailleur.logements.edit', $logement)])
Modifier mon logement
@endcomponent

Merci,<br>
{{ config('app.name') }}
@endcomponent
