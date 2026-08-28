@component('mail::message')
# Votre nouveau mot de passe Flux

Bonjour {{ $user->nom }},

Votre mot de passe a été réinitialisé. Utilisez le mot de passe temporaire ci-dessous pour vous connecter :

@component('mail::panel')
<div style="text-align:center; font-size:22px; font-weight:bold; letter-spacing:2px;">{{ $temporaryPassword }}</div>
@endcomponent

Pour protéger votre compte, pensez à le remplacer depuis votre profil après votre connexion. Si vous n'êtes pas à l'origine de cette demande, contactez-nous rapidement.

Merci,<br>
L'équipe {{ config('app.name') }}
@endcomponent
