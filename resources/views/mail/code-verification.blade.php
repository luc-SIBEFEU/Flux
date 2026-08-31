@component('mail::message')
# {{ __('mail.verifiez_email_titre') }}

{{ __('mail.bonjour', ['nom' => $user->nom]) }},

{{ __('mail.merci_inscription') }}

@component('mail::panel')
<div style="text-align:center; font-size:28px; font-weight:bold; letter-spacing:6px;">{{ $user->code_verification }}</div>
@endcomponent

{{ __('mail.code_expire_15min') }}

{{ __('mail.si_pas_origine_inscription') }}

{{ __('mail.merci') }},<br>
{{ __('mail.equipe') }} {{ config('app.name') }}
@endcomponent
