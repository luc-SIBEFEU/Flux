<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Espace hôtelier — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900 antialiased">
    <div class="flex min-h-screen">
        <aside class="w-64 bg-gray-950 text-white flex-shrink-0 relative">
            <div class="p-5 text-lg font-bold border-b border-white/10">
                🏨 <span class="text-amber-400">Hôtelier</span>
            </div>
            <nav class="p-3 space-y-1 text-sm">
                <a href="{{ route('hotelier.dashboard') }}" class="block px-4 py-2 rounded-lg hover:bg-white/10 {{ request()->routeIs('hotelier.dashboard') ? 'bg-violet-700' : '' }}">📊 Tableau de bord</a>
                <a href="{{ route('hotelier.hotels.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/10 {{ request()->routeIs('hotelier.hotels.*') ? 'bg-violet-700' : '' }}">🏨 Mes hôtels</a>
                <a href="{{ route('hotelier.reservations.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/10 {{ request()->routeIs('hotelier.reservations.*') ? 'bg-violet-700' : '' }}">📅 Réservations</a>
                <a href="{{ route('hotelier.payment-contacts.edit') }}" class="block px-4 py-2 rounded-lg hover:bg-white/10 {{ request()->routeIs('hotelier.payment-contacts.*') ? 'bg-violet-700' : '' }}">💳 Contacts paiement</a>
                <a href="{{ route('hotelier.profile.edit') }}" class="block px-4 py-2 rounded-lg hover:bg-white/10 {{ request()->routeIs('hotelier.profile.*') ? 'bg-violet-700' : '' }}">👤 Mon profil</a>
            </nav>
            <div class="p-3 border-t border-white/10 absolute bottom-0 w-64">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-white/10 rounded-lg">🚪 Déconnexion</button>
                </form>
            </div>
        </aside>

        <div class="flex-1">
            <header class="bg-white border-b px-6 h-16 flex items-center justify-end">
                <div class="flex items-center gap-2">
                    <img src="{{ auth()->user()->avatarUrl() }}" class="w-8 h-8 rounded-full">
                    <span class="text-sm font-medium">{{ auth()->user()->nom }}</span>
                </div>
            </header>

            @if (session('success'))
                <div class="px-6 pt-4">
                    <div class="bg-green-50 text-green-700 px-4 py-2 rounded-lg">{{ session('success') }}</div>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</body>
</html>
