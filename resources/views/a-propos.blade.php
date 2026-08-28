@extends('layouts.app')
@section('titre', 'À propos de Flux')

@section('contenu')
<section class="bg-flux-bleu text-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 sm:py-28">
        <p class="text-flux-or text-sm font-medium uppercase tracking-widest">À propos de Flux</p>
        <h1 class="font-display text-4xl sm:text-6xl max-w-3xl mt-3 leading-tight">Le séjour commence avec une expérience plus simple.</h1>
        <p class="text-white/70 max-w-2xl mt-6 text-lg leading-relaxed">Flux réunit la réservation hôtelière et la recherche de logements dans une plateforme pensée pour rapprocher les voyageurs, les locataires et les professionnels de l'hébergement.</p>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 sm:py-24">
    <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-start">
        <div>
            <p class="text-flux-or text-sm font-medium uppercase tracking-widest">Notre mission</p>
            <h2 class="font-display text-3xl sm:text-4xl text-flux-noir mt-2">Rendre chaque recherche plus claire et chaque réservation plus sereine.</h2>
        </div>
        <div class="space-y-5 text-flux-noir/65 leading-relaxed">
            <p>Nous croyons que trouver un lieu où dormir ne devrait pas être compliqué. Flux rassemble les informations essentielles au même endroit pour permettre à chacun de décider avec confiance.</p>
            <p>La plateforme accompagne également les hôteliers et les bailleurs dans la présentation de leurs offres, la gestion de leur activité et la relation avec leurs clients.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mt-16">
        <div class="border-t-2 border-flux-bleu pt-5">
            <x-icon name="building" class="w-7 h-7 text-flux-bleu mb-4" />
            <h3 class="font-semibold">Hôtels</h3>
            <p class="text-sm text-flux-noir/60 mt-2 leading-relaxed">Explorez les établissements, leurs chambres, équipements et avis.</p>
        </div>
        <div class="border-t-2 border-flux-violet pt-5">
            <x-icon name="key" class="w-7 h-7 text-flux-violet mb-4" />
            <h3 class="font-semibold">Logements</h3>
            <p class="text-sm text-flux-noir/60 mt-2 leading-relaxed">Trouvez un logement adapté à votre quotidien et échangez avec son bailleur.</p>
        </div>
        <div class="border-t-2 border-flux-or pt-5">
            <x-icon name="users" class="w-7 h-7 text-flux-or mb-4" />
            <h3 class="font-semibold">Une communauté</h3>
            <p class="text-sm text-flux-noir/60 mt-2 leading-relaxed">Une mise en relation de proximité, soutenue par des informations fiables.</p>
        </div>
    </div>
</section>

<section class="bg-white border-y border-black/5 py-20 sm:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mb-10">
            <p class="text-flux-or text-sm font-medium uppercase tracking-widest">L'équipe Flux</p>
            <h2 class="font-display text-3xl sm:text-4xl text-flux-noir mt-2">Les personnes derrière la plateforme.</h2>
            <p class="text-flux-noir/60 mt-4 leading-relaxed">Une équipe engagée pour construire une expérience utile, accessible et proche des réalités du terrain.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <article class="bg-flux-brume shadow-sm border border-black/5 hover:shadow-lg transition-shadow rounded-2xl p-6 sm:p-8 flex flex-col items-center text-center gap-6">
                <div style="border-radius:50%;" class="w-40 h-40 shrink-0 border-2 border-dashed border-flux-bleu/40 bg-white flex flex-col items-center justify-center text-flux-bleu/50" aria-label="Espace réservé à la photo de profil">
                    <!-- <x-icon name="camera" class="w-7 h-7" /> -->
                     <img src="{{ asset('img/luc.jpg') }}" alt="" style="border-radius:50%;" class="w-40 h-40 shrink-0 border-2 border-dashed border-flux-bleu/40 object-cover">
                    <!-- <span class="text-[10px] uppercase tracking-wide mt-2">Photo</span> -->
                </div>
                <div style="font-family:calibri !important;" class="text-center">
                    <h3 class="font-display text-2xl text-flux-noir">SIBEFEU NZEYOC LUC MARC</h3>
                    <p class="text-flux-bleu font-medium text-sm mt-1">ING Informaticien</p>
                    <p class="text-sm text-flux-noir/60 mt-4 leading-relaxed">Conception technique et développement de la plateforme Flux.</p>
                </div>
            </article>
            <article class="bg-flux-brume shadow-sm border border-black/5 hover:shadow-lg transition-shadow rounded-2xl p-6 sm:p-8 flex flex-col items-center text-center gap-6">
                <div style="border-radius:50%;" class="w-40 h-40 shrink-0 border-2 border-dashed border-flux-violet/40 bg-white flex flex-col items-center justify-center text-flux-violet/50" aria-label="Espace réservé à la photo de profil">
                    <!-- <x-icon name="camera" class="w-7 h-7" />
                    <span class="text-[10px] uppercase tracking-wide mt-2">Photo</span> -->
                    <img src="{{ asset('img/noutta.jpg') }}" alt="" style="border-radius:50%;" class="w-40 h-40 shrink-0 border-2 border-dashed border-flux-bleu/40 object-cover">
                </div>
                <div class="text-center">
                    <h3 class="font-display text-2xl text-flux-noir">NOUTTA TCHOUNDJEN Derrick Herman</h3>
                    <p class="text-flux-violet font-medium text-sm mt-1">Chef projet</p>
                    <p class="text-sm text-flux-noir/60 mt-4 leading-relaxed">Coordination du projet et vision produit de la plateforme Flux.</p>
                </div>
            </article>
        </div>
    </div>
</section>

<section class=" px-4 sm:px-6 lg:px-8 py-20 sm:py-24">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- <div class="gap-8 lg:gap-20 items-start"> -->
        <div class="space-y-5 text-flux-noir leading-relaxed">
            <p>Ce Logiciel est développé par <span class="font-display text-flux-noir">NOUTTA SARL</span> en collaboration avec <span>ANTIC</span> et intègre les paiements via AANGARAA-PAY (<a class="text-flux-bleu underline" href="https://aangara-pay.com">aangaraa-pay.com</a>)</p>
        </div>
    
        <div class="max-w-2xl mb-10">
            <p class="text-flux-or mt-6 text-sm font-medium uppercase tracking-widest">L'entreprise </p>
            <h2 class="font-display text-3xl sm:text-4xl text-flux-noir mt-1">NOUTTA SARL</h2>
            <p class="text-flux-noir/60 mt-4 leading-relaxed">
            Nous sommes une entreprise multisectorielle, dynamique et structurée, dirigée par M. NOUTTA TCHOUNDJEN Derrick Herman, qui met son expertise et son professionnalisme au service des entreprises, des particuliers et de l'administration.
            </p>
            <p class="text-flux-or mt-4 text-sm font-medium uppercase tracking-widest">NOS DOMAINES D'EXPERTISE : </p>
            <div class="relative mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-5">
                <div class="hidden lg:block absolute top-6 left-[10%] right-[10%] border-t-2 border-dashed border-flux-violet/20"></div>
                <div class="relative">
                    <div class="w-12 h-12 rounded-full bg-flux-bleu text-white flex items-center justify-center font-display text-xl mb-5 ring-8 ring-flux-brume">1</div>
                        <!-- <x-icon name="users" class="w-6 h-6 text-flux-bleu mb-3" /> -->
                    <h3 class="font-semibold text-flux-noir">Commerce & Logistique Internationale</h3>
                    <p class="text-sm text-flux-noir/60 mt-2 leading-relaxed">Paiement en ligne, Commerce Général, Import-Export, Déclaration en Douane, Transport et Logistique.</p>
                </div>

                <div class="relative">
                    <div class="w-12 h-12 rounded-full bg-flux-bleu text-white flex items-center justify-center font-display text-xl mb-5 ring-8 ring-flux-brume">2</div>
                        <!-- <x-icon name="users" class="w-6 h-6 text-flux-bleu mb-3" /> -->
                    <h3 class="font-semibold text-flux-noir">BTP & Développement </h3>
                    <p class="text-sm text-flux-noir/60 mt-2 leading-relaxed">Bureau d'études, Travaux de Bâtiment, Agriculture et Extraction.</p>
                </div>

                <div class="relative">
                    <div class="w-12 h-12 rounded-full bg-flux-bleu text-white flex items-center justify-center font-display text-xl mb-5 ring-8 ring-flux-brume">3</div>
                        <!-- <x-icon name="users" class="w-6 h-6 text-flux-bleu mb-3" /> -->
                    <h3 class="font-semibold text-flux-noir">Services aux Entreprises </h3>
                    <p class="text-sm text-flux-noir/60 mt-2 leading-relaxed">Cabinet Conseil, Audit, Prestations de services divers et Secrétariat Bureautique professionnel.</p>
                </div>
            </div>
            <p class="text-flux-noir mt-4 leading-relaxed">Contacts</p>
            <p class="flex"><x-icon name="mail" /> <a href="mailto:noutta.cm@gmail.com" class="text-flux-bleu">noutta.cm@gmail.com</a></p>
            <p class="flex"><x-icon name="phone" /> +237 671 22 32 44 /+237 696 11 75 74</p>
            <p class="flex"><x-icon name="map-pin" /> Ambam</p>
        </div>
        <p class="text-flux-or mt-6 text-sm font-medium uppercase tracking-widest">PARTENAIRES : </p>
        <div class="flex sm:grid sm:grid-cols-2 lg:grid-cols-7 gap-4 overflow-x-auto pb-4 sm:overflow-visible sm:pb-0">
            
            <article class="w-40 shrink-0 p-6 sm:w-auto sm:shrink sm:p-8 flex flex-col items-center text-center gap-6">

                <div style="border-radius:50%;" class="w-30 h-30 shrink-0 border-2 border-dashed border-flux-violet/40 bg-white flex flex-col items-center justify-center text-flux-violet/50" aria-label="Espace réservé à la photo de profil">
                    <img src="{{ asset('img/noutta_sarl.jpg') }}" alt="" style="border-radius:50%;">
                </div>    
                <p>NOUTTA SARL</p>
            </article>

            <article class="w-40 shrink-0 p-6 sm:w-auto sm:shrink sm:p-8 flex flex-col items-center text-center gap-6">

                <div style="border-radius:50%;" class="w-30 h-30 shrink-0 border-2 border-dashed border-flux-violet/40 bg-white flex flex-col items-center justify-center text-flux-violet/50" aria-label="Espace réservé à la photo de profil">
                    <img src="{{ asset('img/douanes.jpeg') }}" alt="" style="border-radius:50%;">
                </div>
                <p>Douannes Camerounaises</p>
            </article>

            <article class="w-40 shrink-0 p-6 sm:w-auto sm:shrink sm:p-8 flex flex-col items-center text-center gap-6">

                <div style="border-radius:50%;" class="w-30 h-30 shrink-0 border-2 border-dashed border-flux-violet/40 bg-white flex flex-col items-center justify-center text-flux-violet/50" aria-label="Espace réservé à la photo de profil">
                    <img src="{{ asset('img/estlc.jpg') }}" alt="" >
                </div>
                <p>ESTLC</p>
            </article>

            <article class="w-40 shrink-0 p-6 sm:w-auto sm:shrink sm:p-8 flex flex-col items-center text-center gap-6">

                <div style="border-radius:50%;" class="w-30 h-30 shrink-0 border-2 border-dashed border-flux-violet/40 bg-white flex flex-col items-center justify-center text-flux-violet/50" aria-label="Espace réservé à la photo de profil">
                    <img src="{{ asset('img/dgi.png') }}" alt="" style="border-radius:50%;">
                </div>
                <p>DGI</p>
            </article>

            <article class="w-40 shrink-0 p-6 sm:w-auto sm:shrink sm:p-8 flex flex-col items-center text-center gap-6">

                <div style="border-radius:50%;" class="w-30 h-30 shrink-0 border-2 border-dashed border-flux-violet/40 bg-white flex flex-col items-center justify-center text-flux-violet/50" aria-label="Espace réservé à la photo de profil">
                    <img src="{{ asset('img/antic.jpeg') }}" alt="" style="border-radius:50%;">
                </div>
                <p>ANTIC</p>
            </article>

            <article class="w-40 shrink-0 p-6 sm:w-auto sm:shrink sm:p-8 flex flex-col items-center text-center gap-6">

                <div style="border-radius:50%;" class="w-30 h-30 shrink-0 border-2 border-dashed border-flux-violet/40 bg-white flex flex-col items-center justify-center text-flux-violet/50" aria-label="Espace réservé à la photo de profil">
                    <img src="{{ asset('img/ens.jpg') }}" alt="" style="border-radius:50%;">
                </div>
                <p>ENS</p>
            </article>

            <article class="w-40 shrink-0 p-6 sm:w-auto sm:shrink sm:p-8 flex flex-col items-center text-center gap-6">

                <div style="border-radius:50%;" class="w-30 h-30 shrink-0 border-2 border-dashed border-flux-violet/40 bg-white flex flex-col items-center justify-center text-flux-violet/50" aria-label="Espace réservé à la photo de profil">
                    <img src="{{ asset('img/campost.png') }}" alt="" style="border-radius:50%;">
                </div>
                <p>CAMPOST</p>
            </article>
        </div>
    </div>
</section>    
@endsection
