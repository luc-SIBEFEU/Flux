<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titre', __('dashboard.titre_defaut'))</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <script defer src="{{ asset('js/cdn.min.js') }}"></script>
    <script src="{{ asset('js/chart.js@4') }}"></script>
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="min-h-screen bg-flux-brume antialiased" x-data="{ sidebarOpen: false }">

    <div class="lg:hidden sticky top-0 z-30 bg-flux-noir text-white h-14 flex items-center justify-between px-4">
        <button @click="sidebarOpen = true" aria-label="{{ __('dashboard.ouvrir_menu') }}"><x-icon name="menu" class="w-6 h-6" /></button>
        <span class="font-display text-lg">Flux</span>
        <div class="flex items-center gap-3">
            <p class="text-xs text-white/60">{{ auth()->user()->forfait->nom ?? 'free' }}</p>
            <span class="[&_button]:text-white/70 [&_button:hover]:text-white [&_span]:text-white/70">
                <x-language-switcher />
            </span>
            <span class="[&_button]:text-white/70 [&_button:hover]:text-white">@include('partials.notifications-bell')</span>
            <a href="{{ route('accueil') }}" class="text-xs text-white/60">{{ __('dashboard.voir_le_site') }}</a>
        </div>
    </div>

    <div class="flex">
        <!-- Sidebar mobile (overlay) -->
        <div x-show="sidebarOpen" x-cloak class="fixed inset-0 z-40 lg:hidden">
            <div class="absolute inset-0 bg-black/50" @click="sidebarOpen = false"></div>
            <aside class="relative w-72 h-full bg-flux-noir text-white overflow-y-auto">
                @include('partials.sidebar-' . $espaceRole, ['espaceLabel' => $espaceLabel ?? ''])
            </aside>
        </div>

        <!-- Sidebar desktop -->
        <aside class="hidden lg:flex lg:flex-col w-64 h-screen sticky top-5 bg-flux-noir rounded-2xl  text-white overflow-y-auto">
            @include('partials.sidebar-' . $espaceRole, ['espaceLabel' => $espaceLabel ?? ''])
        </aside>

        <div class="flex-1 min-w-0">
            <header class="hidden lg:flex items-center justify-between px-8 h-16 bg-white border-b border-black/5">
                <h1 class="font-display text-xl text-flux-noir">@yield('titre_page', __('dashboard.titre_defaut_court'))</h1>
                <div class="flex items-center gap-4">
                    <x-language-switcher />
                    @include('partials.notifications-bell')
                    <span class="text-sm text-flux-noir/60">{{ auth()->user()->nom }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="p-2 text-flux-noir/40 hover:text-flux-noir" title="{{ __('navigation.deconnexion') }}"><x-icon name="logout" class="w-5 h-5" /></button>
                    </form>
                </div>
            </header>

            <main class="p-4 sm:p-6 lg:p-8">
                @if (session('success'))
                    <div class="mb-6 flex items-center gap-2 bg-flux-bleu-pale text-flux-bleu px-4 py-3 rounded-xl text-sm">
                        <x-icon name="check-circle" class="w-5 h-5 shrink-0" /> {{ session('success') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="mb-6 flex items-start gap-2 bg-red-50 text-red-700 px-4 py-3 rounded-xl text-sm">
                        <x-icon name="x-circle" class="w-5 h-5 shrink-0 mt-0.5" />
                        <ul class="space-y-1">
                            @foreach ($errors->all() as $erreur)
                                <li>{{ $erreur }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('contenu')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
