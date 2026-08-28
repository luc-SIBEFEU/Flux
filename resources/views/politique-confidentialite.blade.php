@extends('layouts.app')
@section('titre', 'Politique de confidentialité — Flux')

@section('contenu')
<section class="bg-flux-bleu text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
        <p class="text-flux-or text-sm font-medium uppercase tracking-widest">Protection de vos données</p>
        <h1 class="font-display text-4xl sm:text-5xl mt-3">Politique de confidentialité</h1>
        <p class="text-white/65 mt-5">Dernière mise à jour : {{ date('d/m/Y') }}</p>
    </div>
</section>

<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
    <div class="space-y-12 text-flux-noir/70 leading-relaxed">
        <div>
            <h2 class="font-display text-2xl text-flux-noir mb-3">1. Notre engagement</h2>
            <p>Flux accorde une importance particulière à la protection de vos données personnelles. Cette politique explique quelles informations sont collectées lorsque vous utilisez la plateforme, pourquoi elles sont utilisées et quels sont vos droits.</p>
        </div>
        <div>
            <h2 class="font-display text-2xl text-flux-noir mb-3">2. Données collectées</h2>
            <p>Lors de la création d'un compte ou de l'utilisation de nos services, nous pouvons collecter votre nom, adresse e-mail, numéro de téléphone, sexe, rôle de compte et informations nécessaires au traitement de vos réservations, demandes de logement et paiements.</p>
        </div>
        <div>
            <h2 class="font-display text-2xl text-flux-noir mb-3">3. Utilisation des données</h2>
            <p>Vos données nous permettent de créer et sécuriser votre compte, traiter vos réservations et demandes, faciliter les échanges avec les hôteliers et bailleurs, gérer les paiements, vous envoyer les notifications utiles et améliorer le fonctionnement de Flux.</p>
        </div>
        <div>
            <h2 class="font-display text-2xl text-flux-noir mb-3">4. Partage des informations</h2>
            <p>Nous ne vendons pas vos données personnelles. Certaines informations strictement nécessaires peuvent être communiquées au prestataire concerné par une réservation ou une demande, ainsi qu'aux services techniques et de paiement indispensables à l'exécution du service.</p>
        </div>
        <div>
            <h2 class="font-display text-2xl text-flux-noir mb-3">5. Conservation et sécurité</h2>
            <p>Nous conservons vos données pendant la durée nécessaire à la gestion de votre compte, à l'exécution de nos services et au respect de nos obligations légales. Des mesures techniques et organisationnelles raisonnables sont mises en œuvre pour protéger vos informations contre l'accès, la modification ou la divulgation non autorisés.</p>
        </div>
        <div>
            <h2 class="font-display text-2xl text-flux-noir mb-3">6. Cookies et données techniques</h2>
            <p>Flux peut utiliser des cookies ou des technologies similaires nécessaires au fonctionnement de la session, à la sécurité et à la mémorisation de certaines préférences. Des données techniques peuvent également être recueillies pour assurer la stabilité et la sécurité de la plateforme.</p>
        </div>
        <div>
            <h2 class="font-display text-2xl text-flux-noir mb-3">7. Vos droits</h2>
            <p>Selon la réglementation applicable, vous pouvez demander l'accès, la rectification ou la suppression de vos données, ainsi que la limitation ou l'opposition à certains traitements. Pour exercer vos droits, écrivez-nous à <a href="mailto:noutta.cm@gmail.com" class="text-flux-bleu font-medium hover:underline">noutta.cm@gmail.com</a>.</p>
        </div>
        <div>
            <h2 class="font-display text-2xl text-flux-noir mb-3">8. Évolution de la politique</h2>
            <p>Cette politique peut être mise à jour pour tenir compte de l'évolution de Flux, de ses services ou de la réglementation. La version publiée sur cette page indique la date de sa dernière mise à jour.</p>
        </div>
    </div>
</section>
@endsection
