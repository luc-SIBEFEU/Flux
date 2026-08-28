<header class="sticky top-0 z-40 bg-flux-blanc/90 backdrop-blur border-b border-black/5">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between" x-data="{ open: false }">
        <a href="{{ route('accueil') }}" class="flex items-center gap-2 shrink-0">
            <span class="w-9 h-9 rounded-full bg-flux-bleu flex items-center justify-center">
                <x-icon name="sparkles" class="w-5 h-5 text-flux-or" />
            </span>
            <span class="font-display text-xl font-semibold text-flux-bleu">Flux</span>
        </a>

        <div class="hidden md:flex items-center gap-8 text-sm font-medium text-flux-noir/80">
            <a href="{{ route('hotels.index') }}" class="hover:text-flux-bleu transition-colors {{ request()->routeIs('hotels.*') ? 'text-flux-bleu' : '' }}">Hôtels</a>
            <a href="{{ route('logements.index') }}" class="hover:text-flux-violet transition-colors {{ request()->routeIs('logements.*') ? 'text-flux-violet' : '' }}">Logements</a>
            <a href="{{ route('a-propos') }}" class="hover:text-flux-bleu transition-colors {{ request()->routeIs('a-propos') ? 'text-flux-bleu' : '' }}">À propos</a>
            <!-- <a href="{{ route('accueil') }}#actualites" class="hover:text-flux-bleu transition-colors">Actualités</a> -->
        </div>

        <div class="hidden md:flex items-center gap-3">
            @auth
                @php $espace = match(auth()->user()->role){'admin'=>'admin.dashboard','hotelier'=>'hotelier.dashboard','bailleur'=>'bailleur.dashboard',default=>'client.reservations.index'}; @endphp
                <a href="{{ route($espace) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-flux-bleu text-white text-sm font-medium hover:bg-flux-bleu-vif transition-colors">
                    <x-icon name="user" class="w-4 h-4" /> {{ auth()->user()->nom }}
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="p-2 text-flux-noir/50 hover:text-flux-noir" title="Déconnexion"><x-icon name="logout" class="w-5 h-5" /></button>
                </form>
            @else
                <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-flux-noir/80 hover:text-flux-bleu">Connexion</a>
                <a href="{{ route('register') }}" class="px-4 py-2 rounded-full bg-flux-or text-flux-noir text-sm font-semibold hover:bg-flux-or-vif transition-colors">Créer un compte</a>
            @endauth
        </div>

        <button class="md:hidden p-2" @click="open = !open" aria-label="Ouvrir le menu">
            <x-icon name="menu" class="w-6 h-6 text-flux-bleu" />
        </button>

        <div x-show="open" x-cloak @click.outside="open = false"
             class="absolute top-16 inset-x-0 bg-white border-b border-black/5 md:hidden px-4 py-4 space-y-3 shadow-lg">
            <a href="{{ route('hotels.index') }}" class="block py-2 font-medium">Hôtels</a>
            <a href="{{ route('logements.index') }}" class="block py-2 font-medium">Logements</a>
            <a href="{{ route('a-propos') }}" class="block py-2 font-medium">À propos</a>
            <a href="{{ route('accueil') }}#actualites" class="block py-2 font-medium">Actualités</a>
            <hr class="border-black/5">
            @auth
                @php $espace = match(auth()->user()->role){'admin'=>'admin.dashboard','hotelier'=>'hotelier.dashboard','bailleur'=>'bailleur.dashboard',default=>'client.reservations.index'}; @endphp
                <a href="{{ route($espace) }}" class="block py-2 font-medium text-flux-bleu">Mon espace</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="py-2 font-medium text-flux-noir/60">Déconnexion</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block py-2 font-medium">Connexion</a>
                <a href="{{ route('register') }}" class="block py-2 font-semibold text-flux-or">Créer un compte</a>
            @endauth
        </div>
    </nav>
</header>
