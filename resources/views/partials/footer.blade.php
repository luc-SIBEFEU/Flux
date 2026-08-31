<footer class="bg-flux-noir text-white/70 mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
        <div>
            <div class="flex items-center gap-2 mb-3">
                <span class="w-8 h-8 rounded-full bg-flux-or/90 flex items-center justify-center">
                    <x-icon name="sparkles" class="w-4 h-4 text-flux-noir" />
                </span>
                <span class="font-display text-lg text-white">Flux</span>
            </div>
            <p class="text-sm leading-relaxed">{{ __('footer.tagline') }}</p>
            
            <div class="mt-5">
                <h4 class="text-white font-medium mb-3 text-sm uppercase tracking-wide">{{ __('navigation.contact') }}</h4>
                <p class="text-sm">{{ __('footer.contactez_nous') }}</p>
                <p class="text-sm mt-2 text-flux" ><i class="bi bi-envelope"></i> <a href="mailto:noutta.cm@gmail.com" class="hover:text-flux-or">noutta.cm@gmail.com</a></p>
            </div>
        </div>
        <div>
            <h4 class="text-white font-medium mb-3 text-sm uppercase tracking-wide">Flux</h4>
            <ul class="space-y-2 text-sm">
                <li><a href="{{ route('a-propos') }}" class="hover:text-flux-or">{{ __('footer.a_propos_de_flux') }}</a></li>
                <li><a href="{{ route('conditions-utilisation') }}" class="hover:text-flux-or">{{ __('navigation.conditions') }}</a></li>
                <li><a href="{{ route('politique-confidentialite') }}" class="hover:text-flux-or">{{ __('navigation.confidentialite') }}</a></li>
                <li><a href="{{ route('aide-faq') }}" class="hover:text-flux-or">{{ __('navigation.faq') }}</a></li>
                <li><a href="{{ route('contact') }}" class="hover:text-flux-or">{{ __('navigation.contact') }}</a></li>
            </ul>
        </div>
        <div>
            <h4 class="text-white font-medium mb-3 text-sm uppercase tracking-wide">{{ __('navigation.logements') }}</h4>
            <ul class="space-y-2 text-sm">
                <li><a href="{{ route('logements.index') }}" class="hover:text-flux-or">{{ __('footer.trouver_logement') }}</a></li>
                <li><a href="{{ route('register', ['type' => 'bailleur']) }}" class="hover:text-flux-or">{{ __('footer.devenir_bailleur') }}</a></li>
            </ul>
            <div class="mt-5"></div>
            <h4 class="text-white font-medium mb-3 text-sm uppercase tracking-wide">{{ __('navigation.hotels') }}</h4>
            <ul class="space-y-2 text-sm">
                <li><a href="{{ route('hotels.index') }}" class="hover:text-flux-or">{{ __('footer.trouver_hotel') }}</a></li>
                <li><a href="{{ route('register', ['type' => 'hotelier']) }}" class="hover:text-flux-or">{{ __('footer.devenir_hotelier') }}</a></li>
            </ul>
        </div>
        <div>
            <h4 class="text-white font-medium mb-3 text-sm uppercase tracking-wide">{{ __('footer.paiement') }}</h4>
            <p class="text-sm">MTN Mobile Money · Orange Money</p>
            <p class="text-xs mt-2 text-white/40">{{ __('footer.paiements_securises') }}</p>

            <div class="mt-5">
                <h4 class="text-white font-medium mb-3 text-sm uppercase tracking-wide">{{ __('footer.reseaux_sociaux') }}</h4>
                <ul class="flex items-center gap-3">
                    <li><a href="#" target="_blank" class="hover:text-flux-or"><i class="bi bi-facebook"></i></a></li>
                    <li><a href="#" target="_blank" class="hover:text-flux-or"><i class="bi bi-instagram"></i></a></li>
                    <li><a href="#" target="_blank" class="hover:text-flux-or"><i class="bi bi-linkedin"></i></a></li>
                </ul>
            </div>

        </div>
    </div>
    <div class="border-t border-white/10 py-5 text-center">
        <div class="mt-2 text-xs text-white/40">© {{ date('Y') }} Flux. {{ __('footer.droits_reserves') }}.</div>
        <div class="mt-2 text-xl font-black tracking-[0.2em] text-white/90 uppercase font-mono">{{ __('footer.developpe_par') }}</div>
    </div>
</footer>
