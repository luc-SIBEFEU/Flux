@component('mail::message')
# Nouveau logement à valider

Le bailleur **{{ $logement->bailleur->nom }}** vient de soumettre un nouveau logement.

@component('mail::panel')
**Type :** {{ ucfirst($logement->type) }} ({{ $logement->categorie }})<br>
**Ville :** {{ $logement->ville }}, {{ $logement->quartier }}<br>
**Prix :** {{ number_format($logement->prix_mois, 0, ',', ' ') }} FCFA / mois
@endcomponent

@component('mail::button', ['url' => route('admin.logements.index')])
Examiner les logements en attente
@endcomponent

Merci,<br>
{{ config('app.name') }}
@endcomponent
