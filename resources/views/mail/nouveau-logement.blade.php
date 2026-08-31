@component('mail::message')
# {{ __('mail.nouveau_logement_titre') }}

{{ __('mail.nouveau_logement_corps', ['bailleur' => $logement->bailleur->nom]) }}

@component('mail::panel')
**{{ __('common.type') }} :** {{ ucfirst($logement->type) }} ({{ $logement->categorie }})<br>
**{{ __('common.ville') }} :** {{ $logement->ville }}, {{ $logement->quartier }}<br>
**{{ __('common.prix') }} :** {{ number_format($logement->prix_mois, 0, ',', ' ') }} FCFA / {{ __('forfait.mois') }}
@endcomponent

@component('mail::button', ['url' => route('admin.logements.index')])
{{ __('mail.examiner_logements_attente') }}
@endcomponent

{{ __('mail.merci') }},<br>
{{ config('app.name') }}
@endcomponent
