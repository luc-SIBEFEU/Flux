@component('mail::message')
# {{ __('mail.nouveau_mdp_titre') }}

{{ __('mail.bonjour', ['nom' => $user->nom]) }},

{{ __('mail.mdp_reinitialise_corps') }}

@component('mail::panel')
<div style="text-align:center; font-size:22px; font-weight:bold; letter-spacing:2px;">{{ $temporaryPassword }}</div>
@endcomponent

{{ __('mail.mdp_conseil_securite') }}

{{ __('mail.merci') }},<br>
{{ __('mail.equipe') }} {{ config('app.name') }}
@endcomponent
