@component('mail::message')
# {{ __('mail.location_terminee_titre') }}

{{ __('mail.bonjour', ['nom' => $baye->client->nom]) }},

{{ __('mail.bail_termine_corps', ['quartier' => $baye->logement->quartier, 'ville' => $baye->logement->ville]) }}

@component('mail::panel')
**{{ __('mail.periode') }} :** {{ $baye->date_debut->format('d/m/Y') }} → {{ $baye->date_fin_prevue->format('d/m/Y') }}<br>
**{{ __('mail.total_paye') }} :** {{ number_format($baye->loyers->where('statut','paye')->sum('montant'), 0, ',', ' ') }} FCFA
@endcomponent

{{ __('mail.merci_confiance') }},<br>
{{ __('mail.equipe') }} {{ config('app.name') }}
@endcomponent
