@component('mail::message')
# {{ __('mail.logement_non_valide_titre') }}

{{ __('mail.bonjour', ['nom' => $logement->bailleur->nom]) }},

{{ __('mail.logement_non_valide_corps', ['type' => ucfirst($logement->type), 'quartier' => $logement->quartier]) }}

@if($logement->motif_rejet)
@component('mail::panel')
{{ $logement->motif_rejet }}
@endcomponent
@endif

{{ __('mail.modifier_soumettre_espace') }}

@component('mail::button', ['url' => route('bailleur.logements.edit', $logement)])
{{ __('mail.modifier_mon_logement') }}
@endcomponent

{{ __('mail.merci') }},<br>
{{ config('app.name') }}
@endcomponent
