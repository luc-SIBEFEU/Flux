@extends('layouts.app')
@section('titre', "Conditions d'utilisation — Flux")

@section('contenu')
<section class="bg-flux-bleu text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
        <p class="text-flux-or text-sm font-medium uppercase tracking-widest">Cadre d'utilisation</p>
        <h1 class="font-display text-4xl sm:text-5xl mt-3">Conditions d'utilisation</h1>
        <p class="text-white/65 mt-5">Dernière mise à jour : {{ date('d/m/Y') }}</p>
    </div>
</section>

<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
    <div class="space-y-12 text-flux-noir/70 leading-relaxed">
        <div>
            <h2 class="font-display text-2xl text-flux-noir mb-3">1. Objet du service</h2>
            <p>Flux est une plateforme de mise en relation qui permet de consulter des offres d'hôtels et de logements, puis de contacter les professionnels ou propriétaires concernés. Flux facilite la recherche et la réservation, mais n'est pas partie au contrat conclu entre l'utilisateur et le prestataire.</p>
        </div>
        <div>
            <h2 class="font-display text-2xl text-flux-noir mb-3">2. Accès et compte</h2>
            <p>L'accès aux fonctionnalités de Flux peut nécessiter la création d'un compte. L'utilisateur s'engage à fournir des informations exactes, à conserver ses identifiants confidentiels et à signaler sans délai toute utilisation non autorisée de son compte.</p>
        </div>
        <div>
            <h2 class="font-display text-2xl text-flux-noir mb-3">3. Offres et réservations</h2>
            <p>Les offres sont publiées sous la responsabilité des hôteliers et bailleurs. L'utilisateur doit vérifier les informations de l'annonce avant toute réservation ou demande. Les conditions, disponibilités, prix et modalités d'annulation applicables sont celles communiquées au moment de la réservation.</p>
        </div>
        <div>
            <h2 class="font-display text-2xl text-flux-noir mb-3">4. Paiements</h2>
            <p>Lorsque le paiement est proposé sur Flux, il est effectué via les moyens indiqués sur la plateforme. L'utilisateur s'engage à utiliser un moyen de paiement dont il est autorisé à disposer. Toute anomalie de paiement doit être signalée au support dans les meilleurs délais.</p>
        </div>
        <div>
            <h2 class="font-display text-2xl text-flux-noir mb-3">5. Comportement des utilisateurs</h2>
            <p>Il est interdit d'utiliser Flux pour publier des informations fausses, contourner un paiement, porter atteinte aux droits d'autrui, diffuser un contenu illicite ou perturber le fonctionnement du service. Flux peut suspendre ou supprimer un compte en cas de manquement.</p>
        </div>
        <div>
            <h2 class="font-display text-2xl text-flux-noir mb-3">6. Responsabilités</h2>
            <p>Flux met en œuvre des moyens raisonnables pour assurer la disponibilité et la fiabilité du service. Toutefois, Flux ne garantit pas l'absence d'interruption et ne peut être tenu responsable des informations publiées par les prestataires, de leurs services ou des événements indépendants de sa volonté.</p>
        </div>
        <div>
            <h2 class="font-display text-2xl text-flux-noir mb-3">7. Données personnelles</h2>
            <p>Les données collectées sont utilisées pour fournir et sécuriser le service, gérer les comptes et traiter les demandes. Elles sont traitées conformément à la réglementation applicable. L'utilisateur peut contacter Flux pour toute question relative à ses données.</p>
        </div>
        <div>
            <h2 class="font-display text-2xl text-flux-noir mb-3">8. Contact et évolution</h2>
            <p>Pour toute question concernant ces conditions, contactez-nous à <a href="mailto:noutta.cm@gmail.com" class="text-flux-bleu font-medium hover:underline">noutta.cm@gmail.com</a>. Flux peut faire évoluer ces conditions; la version publiée sur cette page est la version applicable.</p>
        </div>
    </div>
</section>
@endsection
