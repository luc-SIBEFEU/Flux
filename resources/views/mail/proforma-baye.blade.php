@component('mail::message')
# Votre location est arrivée à son terme

Bonjour {{ $baye->client->nom }},

Votre bail pour le logement de {{ $baye->logement->quartier }}, {{ $baye->logement->ville }} est terminé. Vous trouverez le pro-forma récapitulatif en pièce jointe.

@component('mail::panel')
**Période :** {{ $baye->date_debut->format('d/m/Y') }} → {{ $baye->date_fin_prevue->format('d/m/Y') }}<br>
**Total payé :** {{ number_format($baye->loyers->where('statut','paye')->sum('montant'), 0, ',', ' ') }} FCFA
@endcomponent

Merci de votre confiance,<br>
L'équipe {{ config('app.name') }}
@endcomponent
