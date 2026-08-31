@component('mail::message')
# {{ __('mail.logement_valide_titre') }} ✅

{{ __('mail.bonjour', ['nom' => $logement->bailleur->nom]) }},

{{ __('mail.logement_valide_corps', ['type' => ucfirst($logement->type), 'quartier' => $logement->quartier]) }}

@component('mail::button', ['url' => route('logements.show', $logement)])
{{ __('mail.voir_annonce') }}
@endcomponent

{{ __('mail.merci') }},<br>
{{ config('app.name') }}
@endcomponent
