@extends('layouts.app')
@section('titre', 'Aide - FAQ')

@section('contenu')
<section class="bg-flux-bleu text-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 sm:py-28">
        <p class="text-flux-or text-sm font-medium uppercase tracking-widest">Centre d'aide</p>
        <h1 class="font-display text-4xl sm:text-6xl max-w-3xl mt-3 leading-tight">Questions fréquemment posées</h1>
        <p class="text-white/70 max-w-2xl mt-6 text-lg leading-relaxed">Trouvez les réponses aux questions les plus courantes sur l'utilisation de Flux.</p>
    </div>
</section>

<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-20 sm:py-24">
    <!-- Voyageurs & Clients -->
    <div class="mb-16">
        <p class="text-flux-or text-sm font-medium uppercase tracking-widest mb-2">Pour les voyageurs</p>
        <h2 class="font-display text-3xl text-flux-noir mb-8">Questions des voyageurs et clients</h2>
        
        <div class="space-y-5">
            <!-- FAQ Item 1 -->
            <details class="border border-flux-noir/10 rounded-lg p-6 cursor-pointer group">
                <summary class="flex items-center justify-between font-semibold text-flux-noir hover:text-flux-bleu transition-colors">
                    <span>Comment créer mon compte sur Flux ?</span>
                    <x-icon name="chevron-down" class="w-5 h-5 text-flux-bleu transition-transform group-open:rotate-180" />
                </summary>
                <p class="text-flux-noir/70 leading-relaxed mt-4">
                    Cliquez sur « S'inscrire » en haut à droite, puis remplissez votre email et un mot de passe sécurisé. Confirmez votre email via le lien d'activation envoyé dans votre boîte de réception. Votre compte est prêt !
                </p>
            </details>

            <!-- FAQ Item 2 -->
            <details class="border border-flux-noir/10 rounded-lg p-6 cursor-pointer group">
                <summary class="flex items-center justify-between font-semibold text-flux-noir hover:text-flux-bleu transition-colors">
                    <span>Comment réserver un hôtel ou un logement ?</span>
                    <x-icon name="chevron-down" class="w-5 h-5 text-flux-bleu transition-transform group-open:rotate-180" />
                </summary>
                <p class="text-flux-noir/70 leading-relaxed mt-4">
                    Utilisez la barre de recherche pour indiquer votre destination et vos dates. Parcourez les résultats, sélectionnez votre hébergement préféré et cliquez sur « Réserver ». Suivez les étapes de paiement pour confirmer votre réservation.
                </p>
            </details>

            <!-- FAQ Item 3 -->
            <details class="border border-flux-noir/10 rounded-lg p-6 cursor-pointer group">
                <summary class="flex items-center justify-between font-semibold text-flux-noir hover:text-flux-bleu transition-colors">
                    <span>Comment modifier ou annuler ma réservation ?</span>
                    <x-icon name="chevron-down" class="w-5 h-5 text-flux-bleu transition-transform group-open:rotate-180" />
                </summary>
                <p class="text-flux-noir/70 leading-relaxed mt-4">
                    Connectez-vous à votre compte, allez à « Mes réservations » et sélectionnez la réservation concernée. Les options de modification ou d'annulation dépendent de la politique de l'établissement. Consultez les conditions avant de procéder.
                </p>
            </details>

            <!-- FAQ Item 4 -->
            <details class="border border-flux-noir/10 rounded-lg p-6 cursor-pointer group">
                <summary class="flex items-center justify-between font-semibold text-flux-noir hover:text-flux-bleu transition-colors">
                    <span>Quels modes de paiement acceptez-vous ?</span>
                    <x-icon name="chevron-down" class="w-5 h-5 text-flux-bleu transition-transform group-open:rotate-180" />
                </summary>
                <p class="text-flux-noir/70 leading-relaxed mt-4">
                    Flux accepte les cartes de crédit (Visa, Mastercard, American Express) et les portefeuilles numériques. Tous les paiements sont sécurisés et chiffrés.
                </p>
            </details>

            <!-- FAQ Item 5 -->
            <details class="border border-flux-noir/10 rounded-lg p-6 cursor-pointer group">
                <summary class="flex items-center justify-between font-semibold text-flux-noir hover:text-flux-bleu transition-colors">
                    <span>Comment contacter le propriétaire ou l'hôtel ?</span>
                    <x-icon name="chevron-down" class="w-5 h-5 text-flux-bleu transition-transform group-open:rotate-180" />
                </summary>
                <p class="text-flux-noir/70 leading-relaxed mt-4">
                    Après votre réservation confirmée, vous pouvez contacter directement le propriétaire via la messagerie Flux. Pour les questions avant réservation, utilisez le formulaire de contact présent sur l'annonce.
                </p>
            </details>
        </div>
    </div>

    <!-- Propriétaires & Hôteliers -->
    <div class="mb-16">
        <p class="text-flux-violet text-sm font-medium uppercase tracking-widest mb-2">Pour les professionnels</p>
        <h2 class="font-display text-3xl text-flux-noir mb-8">Questions des propriétaires et hôteliers</h2>
        
        <div class="space-y-5">
            <!-- FAQ Item 6 -->
            <details class="border border-flux-noir/10 rounded-lg p-6 cursor-pointer group">
                <summary class="flex items-center justify-between font-semibold text-flux-noir hover:text-flux-bleu transition-colors">
                    <span>Comment ajouter mon annonce sur Flux ?</span>
                    <x-icon name="chevron-down" class="w-5 h-5 text-flux-violet transition-transform group-open:rotate-180" />
                </summary>
                <p class="text-flux-noir/70 leading-relaxed mt-4">
                    Créez un compte professionnel, accédez au tableau de bord et cliquez sur « Nouvelle annonce ». Complétez les informations de votre hébergement (description, prix, disponibilités, photos) et publiez-la.
                </p>
            </details>

            <!-- FAQ Item 7 -->
            <details class="border border-flux-noir/10 rounded-lg p-6 cursor-pointer group">
                <summary class="flex items-center justify-between font-semibold text-flux-noir hover:text-flux-bleu transition-colors">
                    <span>Y a-t-il des frais pour lister mon hébergement ?</span>
                    <x-icon name="chevron-down" class="w-5 h-5 text-flux-violet transition-transform group-open:rotate-180" />
                </summary>
                <p class="text-flux-noir/70 leading-relaxed mt-4">
                    La création d'annonce est gratuite. Flux prélève une commission sur chaque réservation confirmée. Consultez nos tarifs dans votre espace professionnel.
                </p>
            </details>

            <!-- FAQ Item 8 -->
            <details class="border border-flux-noir/10 rounded-lg p-6 cursor-pointer group">
                <summary class="flex items-center justify-between font-semibold text-flux-noir hover:text-flux-bleu transition-colors">
                    <span>Comment gérer les réservations et la disponibilité ?</span>
                    <x-icon name="chevron-down" class="w-5 h-5 text-flux-violet transition-transform group-open:rotate-180" />
                </summary>
                <p class="text-flux-noir/70 leading-relaxed mt-4">
                    Votre tableau de bord affiche toutes les réservations. Vous pouvez modifier les tarifs et les disponibilités en temps réel via le calendrier interactif de gestion.
                </p>
            </details>

            <!-- FAQ Item 9 -->
            <details class="border border-flux-noir/10 rounded-lg p-6 cursor-pointer group">
                <summary class="flex items-center justify-between font-semibold text-flux-noir hover:text-flux-bleu transition-colors">
                    <span>Comment recevoir les paiements des réservations ?</span>
                    <x-icon name="chevron-down" class="w-5 h-5 text-flux-violet transition-transform group-open:rotate-180" />
                </summary>
                <p class="text-flux-noir/70 leading-relaxed mt-4">
                    Configurez vos coordonnées bancaires dans les paramètres de paiement. Les fonds sont versés automatiquement après chaque réservation (délai selon votre banque).
                </p>
            </details>

            <!-- FAQ Item 10 -->
            <details class="border border-flux-noir/10 rounded-lg p-6 cursor-pointer group">
                <summary class="flex items-center justify-between font-semibold text-flux-noir hover:text-flux-bleu transition-colors">
                    <span>Comment augmenter la visibilité de mon annonce ?</span>
                    <x-icon name="chevron-down" class="w-5 h-5 text-flux-violet transition-transform group-open:rotate-180" />
                </summary>
                <p class="text-flux-noir/70 leading-relaxed mt-4">
                    Optimisez votre annonce avec des photos de qualité, une description détaillée et des tarifs compétitifs. Répondez rapidement aux demandes et encouragez les avis positifs pour améliorer votre classement.
                </p>
            </details>
        </div>
    </div>

    <!-- Compte & Sécurité -->
    <div>
        <p class="text-flux-or text-sm font-medium uppercase tracking-widest mb-2">Compte & Sécurité</p>
        <h2 class="font-display text-3xl text-flux-noir mb-8">Gestion de compte et sécurité</h2>
        
        <div class="space-y-5">
            <!-- FAQ Item 11 -->
            <details class="border border-flux-noir/10 rounded-lg p-6 cursor-pointer group">
                <summary class="flex items-center justify-between font-semibold text-flux-noir hover:text-flux-bleu transition-colors">
                    <span>Mon compte a été bloqué. Que faire ?</span>
                    <x-icon name="chevron-down" class="w-5 h-5 text-flux-or transition-transform group-open:rotate-180" />
                </summary>
                <p class="text-flux-noir/70 leading-relaxed mt-4">
                    Consultez l'email que nous vous avons envoyé pour connaître la raison du blocage. Contactez notre équipe support pour plus de détails et les solutions possibles.
                </p>
            </details>

            <!-- FAQ Item 12 -->
            <details class="border border-flux-noir/10 rounded-lg p-6 cursor-pointer group">
                <summary class="flex items-center justify-between font-semibold text-flux-noir hover:text-flux-bleu transition-colors">
                    <span>Mes données sont-elles sécurisées sur Flux ?</span>
                    <x-icon name="chevron-down" class="w-5 h-5 text-flux-or transition-transform group-open:rotate-180" />
                </summary>
                <p class="text-flux-noir/70 leading-relaxed mt-4">
                    Oui, nous utilisons le chiffrement SSL, la protection par authentification à deux facteurs et respectons les normes RGPD pour protéger vos données personnelles.
                </p>
            </details>

            <!-- FAQ Item 13 -->
            <details class="border border-flux-noir/10 rounded-lg p-6 cursor-pointer group">
                <summary class="flex items-center justify-between font-semibold text-flux-noir hover:text-flux-bleu transition-colors">
                    <span>Comment changer mon mot de passe ?</span>
                    <x-icon name="chevron-down" class="w-5 h-5 text-flux-or transition-transform group-open:rotate-180" />
                </summary>
                <p class="text-flux-noir/70 leading-relaxed mt-4">
                    Connectez-vous à votre compte, allez à « Paramètres » → « Sécurité » et cliquez sur « Modifier le mot de passe ». Suivez les instructions envoyées par email pour confirmer.
                </p>
            </details>

            <!-- FAQ Item 14 -->
            <details class="border border-flux-noir/10 rounded-lg p-6 cursor-pointer group">
                <summary class="flex items-center justify-between font-semibold text-flux-noir hover:text-flux-bleu transition-colors">
                    <span>Je n'arrive pas à me connecter. Que faire ?</span>
                    <x-icon name="chevron-down" class="w-5 h-5 text-flux-or transition-transform group-open:rotate-180" />
                </summary>
                <p class="text-flux-noir/70 leading-relaxed mt-4">
                    Cliquez sur « Mot de passe oublié ? » pour réinitialiser votre mot de passe. Si le problème persiste, contactez notre support via le formulaire de contact.
                </p>
            </details>
        </div>
    </div>
</section>

<!-- Contact Support Section -->
<section class="bg-flux-bleu/5 border-y border-flux-noir/10 py-16 sm:py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <p class="text-flux-bleu text-sm font-medium uppercase tracking-widest mb-3">Besoin d'aide supplémentaire ?</p>
        <h2 class="font-display text-2xl sm:text-3xl text-flux-noir mb-6">Contactez notre équipe support</h2>
        <p class="text-flux-noir/70 mb-8 leading-relaxed">
            Si vous ne trouvez pas la réponse à votre question, nos experts sont là pour vous aider.
        </p>
        <a href="{{ route('contact') }}" class="inline-block bg-flux-bleu text-white px-6 py-3 rounded-lg font-semibold hover:bg-flux-bleu/90 transition-colors">
            Nous contacter
        </a>
    </div>
</section>

<style>
    details > summary::-webkit-details-marker {
        display: none;
    }
</style>
@endsection
