@extends('layouts.app')
@section('titre', __('pages.home_titre'))

@section('contenu')

<!-- Hero + carrousel d'actualités -->
<section class="relative bg-flux-bleu overflow-hidden">
    <div class="absolute inset-0 opacity-20" style="background:radial-gradient(circle at 80% 20%, var(--color-flux-or), transparent 40%)"></div>

    @if($actualites->isNotEmpty())
        <!-- Carrousel d'actualités en fond du hero -->
        <div class="absolute inset-0" x-data="heroCarousel({{ $actualites->count() }})" x-init="demarrer()">
            @foreach($actualites as $i => $actu)
                <div x-show="index === {{ $i }}" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="absolute inset-0">
                    <img src="{{ asset('storage/'.$actu->image) }}" class="w-full h-full object-cover opacity-25">
                    <div class="absolute inset-0 bg-gradient-to-t from-flux-bleu via-flux-bleu/70 to-flux-bleu/40"></div>
                </div>
            @endforeach

            <!-- Contenu texte de l'actualité active -->
            <div class="absolute top-5 sm:top-20 left-10 right-4 sm:left-110 sm:right-auto sm:max-w-md">
                <p class="text-flux-or text-sm font-medium tracking-widest uppercase mb-3">Actualités</p>
                @foreach($actualites as $i => $actu)
                    <div x-show="index === {{ $i }}" x-transition:enter="transition ease-out duration-500 delay-150" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                        <p class="text-flux-or text-xs font-medium uppercase tracking-wide mb-1">{{ $actu->date_debut->format('d M') }} — {{ $actu->date_fin->format('d M Y') }}</p>
                        <h3 class="font-display text-4xl sm:text-5xl lg:text-6xl text-white max-w-2xl leading-[1.05]">{{ $actu->nom }}</h3>
                        <p class="text-white/70 text-sm mt-1 line-clamp-2 max-w-sm">{{ $actu->description }}</p>
                    </div>
                @endforeach

                <!-- Puces de navigation -->
                <div class="flex gap-1.5 mt-4">
                    @foreach($actualites as $i => $actu)
                        <button @click="aller({{ $i }})" class="h-1.5 rounded-full transition-all" :class="index === {{ $i }} ? 'w-6 bg-flux-or' : 'w-1.5 bg-white/40'"></button>
                    @endforeach
                </div>
            </div>

            <!-- Flèches -->
            <button @click="precedent()" class="hidden sm:flex absolute left-4 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 items-center justify-center text-white">
                <x-icon name="chevron-down" class="w-4 h-4 rotate-90" />
            </button>
            <button @click="suivant()" class="hidden sm:flex absolute right-4 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 items-center justify-center text-white">
                <x-icon name="chevron-down" class="w-4 h-4 -rotate-90" />
            </button>
        </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-28 sm:pt-24 sm:pb-36">
    </div>
    @else

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-28 sm:pt-24 sm:pb-36">
        <p class="text-flux-or text-sm font-medium tracking-widest uppercase mb-3">Flux</p>
        <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl text-white max-w-2xl leading-[1.05]">
            {{ __('home.hero.title') }}
        </h1>
        <p class="text-white/70 mt-4 max-w-lg">{{ __('home.hero.subtitle') }}</p>
        <p class="text-white/70 mt-4 max-w-lg">{{ __('home.hero.create_account') }} <br>
        @if(!auth()->user())
        <div class="mt-5 hover:bg-fux-bleu">
        <a href="{{  route('login') }}" class="shadow-sm bg-flux-brume border border-black p-4 rounded-2xl  text-flux-noir"> {{ __('home.hero.login_link') }}</a>
        </div>
        @endif
        </p>
    </div>
    @endif

    <!-- Carte de recherche flottante -->
    <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 sm:mt-20">
        <form action="{{ route('hotels.index') }}" class="bg-white rounded-2xl shadow-xl p-5 sm:p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            <div class="lg:col-span-2">
                <label class="text-xs font-medium text-flux-noir/50">Destination</label>
                <div class="flex items-center gap-2 mt-1 border border-black/10 rounded-lg px-3 py-2.5">
                    <x-icon name="map-pin" class="w-4 h-4 text-flux-bleu shrink-0" />
                    <input type="text" name="destination" placeholder="Ville, quartier..." class="w-full outline-none text-sm">
                </div>
            </div>
            <div>
                <label class="text-xs font-medium text-flux-noir/50">Arrivée</label>
                <div class="flex items-center gap-2 mt-1 border border-black/10 rounded-lg px-3 py-2.5">
                    <x-icon name="calendar" class="w-4 h-4 text-flux-bleu shrink-0" />
                    <input type="date" name="date_arrivee" class="w-full outline-none text-sm">
                </div>
            </div>
            <div>
                <label class="text-xs font-medium text-flux-noir/50">Départ</label>
                <div class="flex items-center gap-2 mt-1 border border-black/10 rounded-lg px-3 py-2.5">
                    <x-icon name="calendar" class="w-4 h-4 text-flux-bleu shrink-0" />
                    <input type="date" name="date_depart" class="w-full outline-none text-sm">
                </div>
            </div>
            <div class="flex gap-2">
                <div class="flex-1">
                    <label class="text-xs font-medium text-flux-noir/50">Adultes</label>
                    <div class="flex items-center gap-2 mt-1 border border-black/10 rounded-lg px-3 py-2.5">
                        <x-icon name="users" class="w-4 h-4 text-flux-bleu shrink-0" />
                        <input type="number" min="1" value="2" name="adultes" class="w-full outline-none text-sm">
                    </div>
                </div>
                <div class="flex-1">
                    <label class="text-xs font-medium text-flux-noir/50">Enfants</label>
                    <div class="mt-1 border border-black/10 rounded-lg px-3 py-2.5">
                        <input type="number" min="0" value="0" name="enfants" class="w-full outline-none text-sm">
                    </div>
                </div>
            </div>
            <button type="submit" class="lg:col-span-5 mt-1 inline-flex items-center justify-center gap-2 bg-flux-or hover:bg-flux-or-vif text-flux-noir font-semibold py-3 rounded-lg transition-colors">
                <x-icon name="search" class="w-5 h-5" /> Rechercher un hôtel
            </button>
        </form>
    </div>
</section>

<!-- Pourquoi Flux ? -->
<section id="pourquoi-flux" class="bg-white border-y border-black/5 py-20 sm:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mb-10">
            <p class="text-flux-or text-sm font-medium uppercase tracking-widest">{{ __('home.why.title') }}</p>
            <h2 class="font-display text-3xl sm:text-4xl text-flux-noir mt-2">{{ __('home.why.subtitle') }}</h2>
            <p class="text-flux-noir/60 mt-4 leading-relaxed">{{ __('home.why.description') }}</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-flux-brume rounded-2xl p-6">
                <x-icon name="search" class="w-7 h-7 text-flux-bleu mb-5" />
                <h3 class="font-semibold text-flux-noir">{{ __('home.why.item1.title') }}</h3>
                <p class="text-sm text-flux-noir/60 mt-2 leading-relaxed">{{ __('home.why.item1.description') }}</p>
            </div>
            <div class="bg-flux-brume rounded-2xl p-6">
                <x-icon name="building" class="w-7 h-7 text-flux-violet mb-5" />
                <h3 class="font-semibold text-flux-noir">{{ __('home.why.item2.title') }}</h3>
                <p class="text-sm text-flux-noir/60 mt-2 leading-relaxed">{{ __('home.why.item2.description') }}</p>
            </div>
            <div class="bg-flux-brume rounded-2xl p-6">
                <x-icon name="heart" class="w-7 h-7 text-flux-bleu mb-5" />
                <h3 class="font-semibold text-flux-noir">{{ __('home.why.item3.title') }}</h3>
                <p class="text-sm text-flux-noir/60 mt-2 leading-relaxed">{{ __('home.why.item3.description') }}</p>
            </div>
            <div class="bg-flux-brume rounded-2xl p-6">
                <x-icon name="coins" class="w-7 h-7 text-flux-or mb-5" />
                <h3 class="font-semibold text-flux-noir">{{ __('home.why.item4.title') }}</h3>
                <p class="text-sm text-flux-noir/60 mt-2 leading-relaxed">{{ __('home.why.item4.description') }}</p>
            </div>
        </div>
        <a href="{{ route('a-propos') }}" class="inline-flex items-center gap-2 mt-8 text-sm font-semibold text-flux-bleu hover:text-flux-violet transition-colors">{{ __('home.why.link.text') }} <span aria-hidden="true">→</span></a>
    </div>
</section>

<!-- Workflow de réservation -->
<section class="bg-flux-brume py-20 sm:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mb-12">
            <p class="text-flux-violet text-sm font-medium uppercase tracking-widest">{{ __('home.workflow.title') }}</p>
            <h2 class="font-display text-3xl sm:text-4xl text-flux-noir mt-2">{{ __('home.workflow.subtitle') }}</h2>
            <p class="text-flux-noir/60 mt-4 leading-relaxed">{{ __('home.workflow.description') }}</p>
        </div>

        <!-- <div class="flex items-start gap-3 bg-white border border-flux-or/40 rounded-xl px-4 py-3 mb-10 max-w-3xl text-sm text-flux-noir/70">
            <x-icon name="user" class="w-5 h-5 text-flux-or shrink-0 mt-0.5" />
            <p><strong class="text-flux-noir">Inscription ou connexion obligatoire :</strong> créez votre compte ou connectez-vous avant toute réservation, demande de logement ou prise de contact.</p>
        </div> -->

        <div class="relative grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-8 lg:gap-5">
            <div class="hidden lg:block absolute top-6 left-[10%] right-[10%] border-t-2 border-dashed border-flux-violet/20"></div>
            <div class="relative">
                <div class="w-12 h-12 rounded-full bg-flux-bleu text-white flex items-center justify-center font-display text-xl mb-5 ring-8 ring-flux-brume">1</div>
                <x-icon name="users" class="w-6 h-6 text-flux-bleu mb-3" />
                <h3 class="font-semibold text-flux-noir">{{ __('home.workflow.step1.title') }}</h3>
                <p class="text-sm text-flux-noir/60 mt-2 leading-relaxed">{{ __('home.workflow.step1.description') }}</p>
            </div>
            <div class="relative">
                <div class="w-12 h-12 rounded-full bg-flux-bleu text-white flex items-center justify-center font-display text-xl mb-5 ring-8 ring-flux-brume">2</div>
                <x-icon name="search" class="w-6 h-6 text-flux-bleu mb-3" />
                <h3 class="font-semibold text-flux-noir">{{ __('home.workflow.step2.title') }}</h3>
                <p class="text-sm text-flux-noir/60 mt-2 leading-relaxed">{{ __('home.workflow.step2.description') }}</p>
            </div>
            <div class="relative">
                <div class="w-12 h-12 rounded-full bg-flux-violet text-white flex items-center justify-center font-display text-xl mb-5 ring-8 ring-flux-brume">3</div>
                <x-icon name="building" class="w-6 h-6 text-flux-violet mb-3" />
                <h3 class="font-semibold text-flux-noir">{{ __('home.workflow.step3.title') }}</h3>
                <p class="text-sm text-flux-noir/60 mt-2 leading-relaxed">{{ __('home.workflow.step3.description') }}</p>
            </div>
            <div class="relative">
                <div class="w-12 h-12 rounded-full bg-flux-or text-flux-noir flex items-center justify-center font-display text-xl mb-5 ring-8 ring-flux-brume">4</div>
                <x-icon name="calendar" class="w-6 h-6 text-flux-or mb-3" />
                <h3 class="font-semibold text-flux-noir">{{ __('home.workflow.step4.title') }}</h3>
                <p class="text-sm text-flux-noir/60 mt-2 leading-relaxed">{{ __('home.workflow.step4.description') }}</p>
            </div>
            <div class="relative">
                <div class="w-12 h-12 rounded-full bg-flux-bleu text-white flex items-center justify-center font-display text-xl mb-5 ring-8 ring-flux-brume">5</div>
                <x-icon name="coins" class="w-6 h-6 text-flux-bleu mb-3" />
                <h3 class="font-semibold text-flux-noir">Payez</h3>
                <p class="text-sm text-flux-noir/60 mt-2 leading-relaxed">Réglez votre réservation/location avec MTN MoMo ou Orange Money.</p>
            </div>
            <div class="relative">
                <div class="w-12 h-12 rounded-full bg-flux-violet text-white flex items-center justify-center font-display text-xl mb-5 ring-8 ring-flux-brume">6</div>
                <x-icon name="check-circle" class="w-6 h-6 text-flux-violet mb-3" />
                <h3 class="font-semibold text-flux-noir">Suivez</h3>
                <p class="text-sm text-flux-noir/60 mt-2 leading-relaxed">Retrouvez l'état de votre réservation/location dans votre espace.</p>
            </div>
        </div>

        <!-- <div class="mt-16 pt-12 border-t border-black/10">
            <div class="max-w-2xl mb-10">
                <p class="text-flux-violet text-sm font-medium uppercase tracking-widest">Workflow logements</p>
                <h3 class="font-display text-2xl sm:text-3xl text-flux-noir mt-2">Trouvez votre prochain logement.</h3>
                <p class="text-flux-noir/60 mt-3 leading-relaxed">Un parcours pensé pour faciliter les échanges entre locataires et bailleurs.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div>
                    <div class="w-11 h-11 rounded-full bg-flux-violet text-white flex items-center justify-center font-display text-lg mb-5">1</div>
                    <x-icon name="search" class="w-6 h-6 text-flux-violet mb-3" />
                    <h4 class="font-semibold text-flux-noir">Recherchez</h4>
                    <p class="text-sm text-flux-noir/60 mt-2 leading-relaxed">Explorez les logements disponibles selon la ville ou le quartier.</p>
                </div>
                <div>
                    <div class="w-11 h-11 rounded-full bg-flux-bleu text-white flex items-center justify-center font-display text-lg mb-5">2</div>
                    <x-icon name="home" class="w-6 h-6 text-flux-bleu mb-3" />
                    <h4 class="font-semibold text-flux-noir">Consultez</h4>
                    <p class="text-sm text-flux-noir/60 mt-2 leading-relaxed">Vérifiez les photos, le loyer, les équipements et les détails du bien.</p>
                </div>
                <div>
                    <div class="w-11 h-11 rounded-full bg-flux-or text-flux-noir flex items-center justify-center font-display text-lg mb-5">3</div>
                    <x-icon name="user" class="w-6 h-6 text-flux-or mb-3" />
                    <h4 class="font-semibold text-flux-noir">Connectez-vous</h4>
                    <p class="text-sm text-flux-noir/60 mt-2 leading-relaxed">Inscrivez-vous ou connectez-vous pour envoyer une demande au bailleur.</p>
                </div>
                <div>
                    <div class="w-11 h-11 rounded-full bg-flux-violet text-white flex items-center justify-center font-display text-lg mb-5">4</div>
                    <x-icon name="mail" class="w-6 h-6 text-flux-violet mb-3" />
                    <h4 class="font-semibold text-flux-noir">Échangez</h4>
                    <p class="text-sm text-flux-noir/60 mt-2 leading-relaxed">Envoyez votre demande et poursuivez les échanges depuis votre espace.</p>
                </div>
            </div>
        </div> -->
    </div>
</section>

<!-- Hôtels en vogue -->
<!-- <section class="max-w-7xl  mx-auto px-4 sm:px-6 lg:px-8 mt-24 mb-24"> -->
<section class="bg-white border-y border-black/5 py-20 sm:py-24">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-end justify-between mb-6">
        <div>
            <p class="text-flux-or text-sm font-medium uppercase tracking-wide">Tendance</p>
            <h2 class="font-display text-2xl sm:text-3xl text-flux-noir">Hôtels en vogue</h2>
        </div>
        <a href="{{ route('hotels.index') }}" class="text-sm font-medium text-flux-bleu hover:underline hidden sm:block">Tout voir →</a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        @foreach($hotelsEnVogue as $hotel)
            <a href="{{ route('hotels.show', $hotel) }}" class="group bg-white rounded-2xl overflow-hidden shadow-sm border border-black/5 hover:shadow-lg transition-shadow">
                <div class="relative">
                    <img src="{{ asset('storage/'.$hotel->image_couverture) }}" alt="{{ $hotel->nom }}" class="w-full h-44 object-cover group-hover:scale-105 transition-transform duration-300">
                    <span class="absolute top-3 left-3 flex items-center gap-1 bg-white/90 backdrop-blur px-2.5 py-1 rounded-full text-xs font-semibold">
                        <x-icon name="star-filled" class="w-3.5 h-3.5 text-flux-or" /> {{ number_format($hotel->note_moyenne, 1) }}
                    </span>
                </div>
                <div class="p-4">
                    <h3 class="font-medium text-flux-noir truncate">{{ $hotel->nom }}</h3>
                    <p class="text-sm text-flux-noir/50 flex items-center gap-1 mt-1">
                        <x-icon name="map-pin" class="w-3.5 h-3.5" /> {{ $hotel->ville }}
                    </p>
                    <div class="flex flex-wrap gap-2 mt-2">
                    @foreach($hotel->equipements as $eq)
                        <span class="text-xs bg-flux-bleu-pale text-flux-bleu px-2.5 py-1 rounded-full"><i class="bi bi-{{ $eq->icone }}"></i> {{ $eq->nom }}</span>
                    @endforeach
                    </div>
                    <div class="flex items-center gap-0.5 mt-2">
                        @for($i=0; $i<$hotel->nombre_etoiles; $i++)
                            <x-icon name="star-filled" class="w-3.5 h-3.5 text-flux-or" />
                        @endfor
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>
</section>

@endsection

@push('scripts')
<script>
function heroCarousel(total) {
    return {
        index: 0,
        total: total,
        interval: null,
        demarrer() {
            if (this.total <= 1) return;
            this.interval = setInterval(() => this.suivant(), 6000);
        },
        suivant() { this.index = (this.index + 1) % this.total; },
        precedent() { this.index = (this.index - 1 + this.total) % this.total; },
        aller(i) {
            this.index = i;
            clearInterval(this.interval);
            this.demarrer();
        }
    }
}
</script>
@endpush
