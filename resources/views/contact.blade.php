@extends('layouts.app')
@section('titre', __('contact.titre') . ' — Flux')

@section('contenu')
<section class="bg-flux-bleu text-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 sm:py-28">
        <p class="text-flux-or text-sm font-medium uppercase tracking-widest">{{ __('navigation.contact') }}</p>
        <h1 class="font-display text-4xl sm:text-6xl max-w-3xl mt-3 leading-tight">{{ __('contact.a_votre_ecoute') }}</h1>
        <p class="text-white/70 max-w-2xl mt-6 text-lg leading-relaxed">{{ __('contact.intro') }}</p>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 sm:py-24">
    <div class="grid lg:grid-cols-3 gap-8 mb-20">
        <!-- Email -->
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0">
                <div class="flex items-center justify-center h-12 w-12 rounded-lg bg-flux-bleu text-white">
                    <x-icon name="mail" class="w-6 h-6" />
                </div>
            </div>
            <div>
                <h3 class="font-semibold text-flux-noir">{{ __('contact.par_email') }}</h3>
                <p class="text-flux-noir/70 text-sm mt-2">{{ __('contact.email_desc') }}</p>
                <a href="mailto:noutta.cm@gmail.com" class="text-flux-bleu font-medium hover:underline mt-2 inline-block">noutta.cm@gmail.com</a>
            </div>
        </div>

        <!-- Téléphone -->
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0">
                <div class="flex items-center justify-center h-12 w-12 rounded-lg bg-flux-violet text-white">
                    <x-icon name="phone" class="w-6 h-6" />
                </div>
            </div>
            <div>
                <h3 class="font-semibold text-flux-noir">{{ __('contact.par_telephone') }}</h3>
                <p class="text-flux-noir/70 text-sm mt-2">{{ __('contact.telephone_desc') }}</p>
                <div class="flex gap-1">
                <a href="tel:+237671223244" class="text-flux-violet font-medium hover:underline mt-2 inline-block">+237 671 22 32 44</a>
                <p>/</p>
                <a href="tel:+237696117574" class="text-flux-violet font-medium hover:underline mt-2 inline-block">+237 696 11 75 74</a>
                </div>
            </div>
        </div>

        <!-- Adresse -->
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0">
                <div class="flex items-center justify-center h-12 w-12 rounded-lg bg-flux-or text-white">
                    <x-icon name="map-pin" class="w-6 h-6" />
                </div>
            </div>
            <div>
                <h3 class="font-semibold text-flux-noir">{{ __('contact.nos_bureaux') }}</h3>
                <p class="text-flux-noir/70 text-sm mt-2">{{ __('contact.adresse') }}</p>
                <a href="#" class="text-flux-or font-medium hover:underline mt-2 inline-block">{{ __('contact.voir_carte') }}</a>
            </div>
        </div>
    </div>

    <!-- Formulaire de contact -->
    <div class="max-w-3xl mx-auto">
        <div class="mb-8">
            <h2 class="font-display text-3xl sm:text-4xl text-flux-noir">{{ __('contact.envoyer_message') }}</h2>
            <p class="text-flux-noir/70 mt-3">{{ __('contact.remplissez_formulaire') }}</p>
        </div>

        <form method="POST" action="{{ route('contact.store') }}" class="space-y-6 bg-white border border-flux-noir/10 rounded-xl p-8">
            @csrf

            <!-- Nom -->
            <div>
                <label for="nom" class="block text-sm font-medium text-flux-noir mb-2">{{ __('contact.votre_nom') }} *</label>
                <input type="text" id="nom" name="nom" required 
                    class="w-full px-4 py-3 border border-flux-noir/20 rounded-lg focus:ring-2 focus:ring-flux-bleu focus:border-transparent outline-none transition @error('nom') border-red-500 @enderror"
                    value="{{ old('nom') }}" placeholder="{{ __('contact.exemple_nom') }}">
                @error('nom')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-flux-noir mb-2">{{ __('contact.votre_email') }} *</label>
                <input type="email" id="email" name="email" required 
                    class="w-full px-4 py-3 border border-flux-noir/20 rounded-lg focus:ring-2 focus:ring-flux-bleu focus:border-transparent outline-none transition @error('email') border-red-500 @enderror"
                    value="{{ old('email') }}" placeholder="jean@exemple.com">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Type de demande -->
            <div>
                <label for="type_demande" class="block text-sm font-medium text-flux-noir mb-2">{{ __('contact.type_demande') }} *</label>
                <select id="type_demande" name="type_demande" required
                    class="w-full px-4 py-3 border border-flux-noir/20 rounded-lg focus:ring-2 focus:ring-flux-bleu focus:border-transparent outline-none transition @error('type_demande') border-red-500 @enderror">
                    <option value="">-- {{ __('common.selectionnez') }} --</option>
                    <option value="support" {{ old('type_demande') === 'support' ? 'selected' : '' }}>{{ __('contact.type_support') }}</option>
                    <option value="reservations" {{ old('type_demande') === 'reservations' ? 'selected' : '' }}>{{ __('contact.type_reservation') }}</option>
                    <option value="paiement" {{ old('type_demande') === 'paiement' ? 'selected' : '' }}>{{ __('contact.type_paiement') }}</option>
                    <option value="partenariat" {{ old('type_demande') === 'partenariat' ? 'selected' : '' }}>{{ __('contact.type_partenariat') }}</option>
                    <option value="autre" {{ old('type_demande') === 'autre' ? 'selected' : '' }}>{{ __('contact.type_autre') }}</option>
                </select>
                @error('type_demande')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Sujet -->
            <div>
                <label for="sujet" class="block text-sm font-medium text-flux-noir mb-2">{{ __('contact.sujet') }} *</label>
                <input type="text" id="sujet" name="sujet" required 
                    class="w-full px-4 py-3 border border-flux-noir/20 rounded-lg focus:ring-2 focus:ring-flux-bleu focus:border-transparent outline-none transition @error('sujet') border-red-500 @enderror"
                    value="{{ old('sujet') }}" placeholder="{{ __('contact.objet_placeholder') }}">
                @error('sujet')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Message -->
            <div>
                <label for="message" class="block text-sm font-medium text-flux-noir mb-2">{{ __('contact.message') }} *</label>
                <textarea id="message" name="message" required rows="6"
                    class="w-full px-4 py-3 border border-flux-noir/20 rounded-lg focus:ring-2 focus:ring-flux-bleu focus:border-transparent outline-none transition @error('message') border-red-500 @enderror"
                    placeholder="{{ __('contact.message_placeholder') }}">{{ old('message') }}</textarea>
                @error('message')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Pièce jointe -->
            <div>
                <label for="piece_jointe" class="block text-sm font-medium text-flux-noir mb-2">{{ __('contact.piece_jointe') }} ({{ __('common.optionnel') }})</label>
                <input type="file" id="piece_jointe" name="piece_jointe"
                    class="w-full px-4 py-3 border border-flux-noir/20 rounded-lg focus:ring-2 focus:ring-flux-bleu focus:border-transparent outline-none transition @error('piece_jointe') border-red-500 @enderror"
                    accept=".pdf,.doc,.docx,.jpg,.png,.gif">
                <p class="text-flux-noir/60 text-xs mt-2">{{ __('contact.formats_acceptes') }}</p>
                @error('piece_jointe')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Consentement -->
            <div class="flex items-start gap-3">
                <input type="checkbox" id="consentement" name="consentement" required
                    class="mt-1 w-4 h-4 rounded border-flux-noir/20 focus:ring-2 focus:ring-flux-bleu @error('consentement') border-red-500 @enderror">
                <label for="consentement" class="text-sm text-flux-noir/70">
                    {{ __('contact.consentement') }} <a href="{{ route('politique-confidentialite') }}" class="text-flux-bleu font-medium hover:underline">{{ __('navigation.confidentialite') }}</a> *
                </label>
            </div>
            @error('consentement')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror

            <!-- Bouton d'envoi -->
            <div class="flex gap-3 pt-4">
                <button type="submit" class="flex-1 bg-flux-bleu text-white font-semibold py-3 rounded-lg hover:bg-flux-bleu/90 transition-colors">
                    {{ __('contact.envoyer_mon_message') }}
                </button>
                <button type="reset" class="flex-1 border border-flux-noir/20 text-flux-noir font-semibold py-3 rounded-lg hover:bg-flux-noir/5 transition-colors">
                    {{ __('common.effacer') }}
                </button>
            </div>

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mt-4">
                    <p class="font-medium">{{ __('contact.message_envoye') }}</p>
                    <p class="text-sm mt-1">{{ __('contact.merci_contact') }}</p>
                </div>
            @endif
        </form>
    </div>
</section>

<!-- Temps de réponse -->
<section class="bg-flux-bleu/5 border-y border-flux-noir/10 py-16 sm:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="font-display text-2xl sm:text-3xl text-flux-noir mb-8 text-center">{{ __('contact.delais_reponse') }}</h2>
        
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-lg p-6 text-center border border-flux-noir/10">
                <div class="text-3xl font-bold text-flux-bleu mb-2">24h</div>
                <p class="text-sm text-flux-noir/70">{{ __('contact.type_support') }}</p>
            </div>
            <div class="bg-white rounded-lg p-6 text-center border border-flux-noir/10">
                <div class="text-3xl font-bold text-flux-violet mb-2">48h</div>
                <p class="text-sm text-flux-noir/70">{{ __('contact.paiement_facturation') }}</p>
            </div>
            <div class="bg-white rounded-lg p-6 text-center border border-flux-noir/10">
                <div class="text-3xl font-bold text-flux-or mb-2">2-3j</div>
                <p class="text-sm text-flux-noir/70">{{ __('contact.type_partenariat') }}</p>
            </div>
            <div class="bg-white rounded-lg p-6 text-center border border-flux-noir/10">
                <div class="text-3xl font-bold text-flux-bleu mb-2">48h</div>
                <p class="text-sm text-flux-noir/70">{{ __('contact.autres_demandes') }}</p>
            </div>
        </div>
    </div>
</section>

<!-- FAQ -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 sm:py-24">
    <div class="max-w-3xl mx-auto text-center mb-12">
        <h2 class="font-display text-2xl sm:text-3xl text-flux-noir mb-3">{{ __('contact.avant_contacter') }}</h2>
        <p class="text-flux-noir/70">{{ __('contact.consulter_faq_desc') }}</p>
    </div>
    
    <div class="text-center">
        <a href="{{ route('aide-faq') }}" class="inline-block bg-flux-bleu text-white px-6 py-3 rounded-lg font-semibold hover:bg-flux-bleu/90 transition-colors">
            {{ __('contact.consulter_faq') }}
        </a>
    </div>
</section>
@endsection
