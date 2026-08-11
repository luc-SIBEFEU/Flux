@component('mail::message')
# Bail terminé

Le bail de **{{ $baye->client->nom }}** pour le logement de {{ $baye->logement->quartier }}, {{ $baye->logement->ville }} est arrivé à son terme (moratoire écoulé).

Le logement est de nouveau visible sur le site et peut être proposé à un nouveau locataire.

@component('mail::button', ['url' => route('bailleur.bayes.index')])
Voir mes locations
@endcomponent

Merci,<br>
{{ config('app.name') }}
@endcomponent
