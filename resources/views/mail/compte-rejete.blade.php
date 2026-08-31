@component('mail::message')
# {{ __('mail.inscription_rejetee_titre') }}

{{ __('mail.bonjour', ['nom' => $user->nom]) }},

{{ __('mail.inscription_rejetee_corps', ['role' => $user->role]) }}

@if($user->motif_rejet_compte)
@component('mail::panel')
{{ $user->motif_rejet_compte }}
@endcomponent
@endif

{{ __('mail.nouvelle_inscription_possible') }}

@component('mail::button', ['url' => route('register', ['type' => $user->role])])
{{ __('mail.nouvelle_inscription_bouton') }}
@endcomponent

{{ __('mail.merci') }},<br>
{{ __('mail.equipe') }} {{ config('app.name') }}
@endcomponent
