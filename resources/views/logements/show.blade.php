@extends('layouts.app')
@section('titre', __('logement.type_' . $logement->type) . ' ' . __('logement_show.a') . ' ' . $logement->ville . ' — Flux')

@section('contenu')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="mb-6">
        <span class="text-xs font-semibold bg-flux-violet-pale text-flux-violet px-3 py-1 rounded-full">{{ __('logement.type_' . $logement->type) }} · {{ $logement->categorie === 'meuble' ? __('logement.meuble') : __('logement.standard') }}</span>
        <h1 class="font-display text-3xl sm:text-4xl text-flux-noir mt-3">{{ __('logement.type_' . $logement->type) }} — {{ $logement->quartier }}</h1>
        <p class="text-flux-noir/50 flex items-center gap-1 mt-1"><x-icon name="map-pin" class="w-4 h-4" /> {{ $logement->quartier }}, {{ $logement->ville }}</p>
    </div>

    @if($logement->photos->isNotEmpty())
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-10 rounded-2xl overflow-hidden">
            @foreach($logement->photos->take(5) as $i => $photo)
                <img src="{{ asset('storage/'.$photo->chemin) }}" class="{{ $i === 0 ? 'col-span-2 row-span-2 min-h-[220px]' : 'min-h-[105px]' }} w-full h-full object-cover">
            @endforeach
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <div class="lg:col-span-2 space-y-10">
            @if($logement->info)
                <section>
                    <h2 class="font-display text-2xl mb-3">{{ __('common.description') }}</h2>
                    <p class="text-flux-noir/70 leading-relaxed">{{ $logement->info }}</p>
                </section>
            @endif

            @if($logement->equipements->isNotEmpty())
                <section>
                    <h2 class="font-display text-2xl mb-3">{{ __('hotel.equipements') }}</h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach($logement->equipements as $eq)
                            <span class="text-sm bg-flux-violet-pale text-flux-violet px-3 py-1.5 rounded-full">{{ $eq->nom }}</span>
                        @endforeach
                    </div>
                </section>
            @endif

            <section>
                <h2 class="font-display text-2xl mb-4">{{ __('sidebar.commentaires') }}</h2>
                <div class="space-y-4">
                    @forelse($logement->commentaires as $com)
                        <div class="border border-black/10 rounded-2xl p-5">
                            <div class="flex items-center justify-between">
                                <span class="font-medium">{{ $com->client->nom }}</span>
                                <span class="flex items-center gap-1 text-flux-or font-semibold text-sm"><x-icon name="star-filled" class="w-4 h-4" /> {{ $com->note }}/10</span>
                            </div>
                            <p class="text-sm text-flux-noir/60 mt-2">{{ $com->commentaire }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-flux-noir/40">{{ __('logement_show.aucun_commentaire') }}</p>
                    @endforelse
                </div>

                @auth
                    <form action="{{ route('commentaires.store', $logement) }}" method="POST" class="mt-6 bg-white border border-black/10 rounded-2xl p-5">
                        @csrf
                        <label class="text-sm font-medium">{{ __('logement_show.laisser_commentaire') }}</label>
                        <textarea name="commentaire" rows="3" class="w-full mt-2 border border-black/10 rounded-lg px-3 py-2 text-sm outline-none focus:border-flux-violet"></textarea>
                        <div class="flex items-center gap-3 mt-3">
                            <input type="number" name="note" min="0" max="10" placeholder="{{ __('logement_show.note_sur_10_court') }}" class="w-28 border border-black/10 rounded-lg px-3 py-2 text-sm outline-none">
                            <button class="bg-flux-violet text-white text-sm font-medium px-4 py-2 rounded-lg">{{ __('actualite.publier') }}</button>
                        </div>
                    </form>
                @endauth
            </section>
        </div>

        <!-- Fiche prix + contact bailleur -->
        <aside class="space-y-5">
            <div class="bg-white border border-black/10 rounded-2xl p-6 sticky top-24">
                <p class="font-display text-3xl text-flux-violet">{{ number_format($logement->prix_mois, 0, ',', ' ') }} FCFA</p>
                <p class="text-xs text-flux-noir/40 mb-4">/ {{ __('forfait.mois') }} ·<span style="color:red;">{{ __('logement.caution') }} {{ number_format($logement->caution, 0, ',', ' ') }} FCFA</span> </p>
                <p class="text-sm text-flux-noir/60 mb-5">{{ __('logement_show.duree_minimum') }} : {{ trans_choice('common.mois_abrege_compte', $logement->duree_min_mois, ['n' => $logement->duree_min_mois]) }}</p>

                @auth
                    @if($logement->bailleur->peutUtiliserFonctionsPro())
                        <form action="{{ route('demandes-baye.store', $logement) }}" method="POST" class="space-y-3">
                            @csrf
                            <input type="tel" name="telephone_client" required placeholder="{{ __('hotel_show.votre_telephone') }}"
                                   class="w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-violet">
                            <div>
                                <label class="text-xs font-medium text-flux-noir/50">{{ __('logement_show.duree_souhaitee', ['n' => $logement->duree_min_mois]) }}</label>
                                <input type="number" name="duree_souhaitee_mois" min="{{ $logement->duree_min_mois }}" value="{{ $logement->duree_min_mois }}" required
                                       class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-violet">
                            </div>
                            <textarea name="message" rows="2" placeholder="{{ __('logement_show.message_bailleur_optionnel') }}"
                                      class="w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-violet"></textarea>
                            <button class="w-full inline-flex items-center justify-center gap-2 bg-flux-violet hover:bg-flux-violet-vif text-white font-semibold py-3 rounded-lg transition-colors">
                                <x-icon name="phone" class="w-4 h-4" /> {{ __('logement_show.envoyer_demande_bail') }}
                            </button>
                        </form>
                    @else
                        <p class="text-xs text-flux-noir/50 mb-3">{{ __('logement_show.pas_gere_ligne') }}</p>
                        <form action="{{ route('logements.contacter', $logement) }}" method="POST" class="space-y-3">
                            @csrf
                            <input type="tel" name="telephone_client" required placeholder="{{ __('hotel_show.votre_telephone') }}"
                                   class="w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-violet">
                            <textarea name="message" rows="3" required placeholder="{{ __('hotel_show.votre_message') }}"
                                      class="w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-violet"></textarea>
                            <button class="w-full inline-flex items-center justify-center gap-2 bg-flux-violet hover:bg-flux-violet-vif text-white font-semibold py-3 rounded-lg transition-colors">
                                <x-icon name="phone" class="w-4 h-4" /> {{ __('logement_show.contacter_bailleur') }}
                            </button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="w-full inline-flex items-center justify-center gap-2 bg-flux-violet text-white font-semibold py-3 rounded-lg">{{ __('logement_show.se_connecter_contacter') }}</a>
                @endauth
            </div>

            @if($logement->google_map_lien || $logement->latitude)
                <div class="rounded-2xl overflow-hidden border border-black/10 h-52">
                    <iframe class="w-full h-full" loading="lazy"
                        src="https://www.google.com/maps?q={{ $logement->latitude ?? $logement->quartier.','.$logement->ville }}&output=embed"></iframe>
                </div>
            @endif
        </aside>
    </div>
</div>
@endsection
