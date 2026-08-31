@component('mail::message')
# {{ __('mail.compte_valide_titre') }} ✅

{{ __('mail.bonjour', ['nom' => $user->nom]) }},

{{ __('mail.compte_valide_corps', ['role' => $user->role]) }}

@component('mail::button', ['url' => route('login')])
{{ __('mail.me_connecter') }}
@endcomponent

{{ __('mail.merci') }},<br>
{{ __('mail.equipe') }} {{ config('app.name') }}
@endcomponent
