@component('mail::message')
# {{ __('mail.baye_termine_titre') }}

{{ __('mail.baye_termine_corps', ['client' => $baye->client->nom, 'quartier' => $baye->logement->quartier, 'ville' => $baye->logement->ville]) }}

{{ __('mail.baye_termine_dispo') }}

@component('mail::button', ['url' => route('bailleur.bayes.index')])
{{ __('mail.voir_mes_locations') }}
@endcomponent

{{ __('mail.merci') }},<br>
{{ config('app.name') }}
@endcomponent
