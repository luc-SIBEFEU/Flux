@component('mail::message')
# Vérifiez votre adresse e-mail

Bonjour {{ $user->nom }},

Merci de vous être inscrit sur **Flux**. Utilisez le code ci-dessous pour finaliser la création de votre compte.

@component('mail::panel')
<div style="text-align:center; font-size:28px; font-weight:bold; letter-spacing:6px;">{{ $user->code_verification }}</div>
@endcomponent

Ce code expire dans 15 minutes.

Si vous n'êtes pas à l'origine de cette inscription, ignorez simplement cet e-mail.

Merci,<br>
L'équipe {{ config('app.name') }}
@endcomponent
