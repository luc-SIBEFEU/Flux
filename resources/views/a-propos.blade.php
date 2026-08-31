@extends('layouts.app')
@section('titre', __('pages.a_propos_titre') . ' — Flux')

@section('contenu')
<section class="bg-flux-bleu text-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 sm:py-28">
        <p class="text-flux-or text-sm font-medium uppercase tracking-widest">{{ __('about.a_propos_de_flux') }}</p>
        <h1 class="font-display text-4xl sm:text-6xl max-w-3xl mt-3 leading-tight">{{ __('about.hero_titre') }}</h1>
        <p class="text-white/70 max-w-2xl mt-6 text-lg leading-relaxed">{{ __('about.hero_desc') }}</p>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 sm:py-24">
    <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-start">
        <div>
            <p class="text-flux-or text-sm font-medium uppercase tracking-widest">{{ __('about.notre_mission') }}</p>
            <h2 class="font-display text-3xl sm:text-4xl text-flux-noir mt-2">{{ __('about.mission_titre') }}</h2>
        </div>
        <div class="space-y-5 text-flux-noir/65 leading-relaxed">
            <p>{{ __('about.mission_p1') }}</p>
            <p>{{ __('about.mission_p2') }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mt-16">
        <div class="border-t-2 border-flux-bleu pt-5">
            <x-icon name="building" class="w-7 h-7 text-flux-bleu mb-4" />
            <h3 class="font-semibold">{{ __('navigation.hotels') }}</h3>
            <p class="text-sm text-flux-noir/60 mt-2 leading-relaxed">{{ __('about.hotels_desc') }}</p>
        </div>
        <div class="border-t-2 border-flux-violet pt-5">
            <x-icon name="key" class="w-7 h-7 text-flux-violet mb-4" />
            <h3 class="font-semibold">{{ __('navigation.logements') }}</h3>
            <p class="text-sm text-flux-noir/60 mt-2 leading-relaxed">{{ __('about.logements_desc') }}</p>
        </div>
        <div class="border-t-2 border-flux-or pt-5">
            <x-icon name="users" class="w-7 h-7 text-flux-or mb-4" />
            <h3 class="font-semibold">{{ __('about.communaute') }}</h3>
            <p class="text-sm text-flux-noir/60 mt-2 leading-relaxed">{{ __('about.communaute_desc') }}</p>
        </div>
    </div>
</section>

<section class="bg-white border-y border-black/5 py-20 sm:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mb-10">
            <p class="text-flux-or text-sm font-medium uppercase tracking-widest">{{ __('about.equipe_flux') }}</p>
            <h2 class="font-display text-3xl sm:text-4xl text-flux-noir mt-2">{{ __('about.equipe_titre') }}</h2>
            <p class="text-flux-noir/60 mt-4 leading-relaxed">{{ __('about.equipe_desc') }}</p>
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
                    <p class="text-flux-bleu font-medium text-sm mt-1">{{ __('about.role_ing') }}</p>
                    <p class="text-sm text-flux-noir/60 mt-4 leading-relaxed">{{ __('about.role_ing_desc') }}</p>
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
                    <p class="text-flux-violet font-medium text-sm mt-1">{{ __('about.role_chef_projet') }}</p>
                    <p class="text-sm text-flux-noir/60 mt-4 leading-relaxed">{{ __('about.role_chef_projet_desc') }}</p>
                </div>
            </article>
        </div>
    </div>
</section>

<section class=" px-4 sm:px-6 lg:px-8 py-20 sm:py-24">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- <div class="gap-8 lg:gap-20 items-start"> -->
        <div class="space-y-5 text-flux-noir leading-relaxed">
            <p>{!! __('about.logiciel_dev_par', ['noutta' => '<span class="font-display text-flux-noir">NOUTTA SARL</span>', 'antic' => '<span>ANTIC</span>', 'lien' => '<a class="text-flux-bleu underline" href="https://aangara-pay.com">aangaraa-pay.com</a>']) !!}</p>
        </div>
    
        <div class="max-w-2xl mb-10">
            <p class="text-flux-or mt-6 text-sm font-medium uppercase tracking-widest">{{ __('about.entreprise') }}</p>
            <h2 class="font-display text-3xl sm:text-4xl text-flux-noir mt-1">NOUTTA SARL</h2>
            <p class="text-flux-noir/60 mt-4 leading-relaxed">
            {{ __('about.entreprise_desc') }}
            </p>
            <p class="text-flux-or mt-4 text-sm font-medium uppercase tracking-widest">{{ __('about.domaines_expertise') }} : </p>
            <div class="relative mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-5">
                <div class="hidden lg:block absolute top-6 left-[10%] right-[10%] border-t-2 border-dashed border-flux-violet/20"></div>
                <div class="relative">
                    <div class="w-12 h-12 rounded-full bg-flux-bleu text-white flex items-center justify-center font-display text-xl mb-5 ring-8 ring-flux-brume">1</div>
                        <!-- <x-icon name="users" class="w-6 h-6 text-flux-bleu mb-3" /> -->
                    <h3 class="font-semibold text-flux-noir">{{ __('about.domaine1_titre') }}</h3>
                    <p class="text-sm text-flux-noir/60 mt-2 leading-relaxed">{{ __('about.domaine1_desc') }}</p>
                </div>

                <div class="relative">
                    <div class="w-12 h-12 rounded-full bg-flux-bleu text-white flex items-center justify-center font-display text-xl mb-5 ring-8 ring-flux-brume">2</div>
                        <!-- <x-icon name="users" class="w-6 h-6 text-flux-bleu mb-3" /> -->
                    <h3 class="font-semibold text-flux-noir">{{ __('about.domaine2_titre') }}</h3>
                    <p class="text-sm text-flux-noir/60 mt-2 leading-relaxed">{{ __('about.domaine2_desc') }}</p>
                </div>

                <div class="relative">
                    <div class="w-12 h-12 rounded-full bg-flux-bleu text-white flex items-center justify-center font-display text-xl mb-5 ring-8 ring-flux-brume">3</div>
                        <!-- <x-icon name="users" class="w-6 h-6 text-flux-bleu mb-3" /> -->
                    <h3 class="font-semibold text-flux-noir">{{ __('about.domaine3_titre') }}</h3>
                    <p class="text-sm text-flux-noir/60 mt-2 leading-relaxed">{{ __('about.domaine3_desc') }}</p>
                </div>
            </div>
            <p class="text-flux-noir mt-4 leading-relaxed">{{ __('about.contacts') }}</p>
            <p class="flex"><x-icon name="mail" /> <a href="mailto:noutta.cm@gmail.com" class="text-flux-bleu">noutta.cm@gmail.com</a></p>
            <p class="flex"><x-icon name="phone" /> +237 671 22 32 44 /+237 696 11 75 74</p>
            <p class="flex"><x-icon name="map-pin" /> {{ __('about.adresse_courte') }}</p>
        </div>
        <p class="text-flux-or mt-6 text-sm font-medium uppercase tracking-widest">{{ __('about.partenaires') }} : </p>
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
                <p>{{ __('about.partenaire_douanes') }}</p>
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
