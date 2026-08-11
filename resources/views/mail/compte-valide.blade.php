@component('mail::message')
# Votre compte a été validé ✅

Bonjour {{ $user->nom }},

Bonne nouvelle : votre compte **{{ $user->role }}** sur Flux vient d'être validé par notre équipe. Vous pouvez dès à présent vous connecter à votre espace.

@component('mail::button', ['url' => route('login')])
Me connecter
@endcomponent

Merci,<br>
L'équipe {{ config('app.name') }}
@endcomponent
