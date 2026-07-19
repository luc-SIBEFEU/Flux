<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'Réservation Hôtelière'))</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900 antialiased">

    <nav class="bg-gray-950 text-white sticky top-0 z-40 shadow">
        <div class="max-w-7xl mx-auto px-4 flex items-center justify-between h-16">
            <a href="{{ route('home') }}" class="text-xl font-bold">
                🏨 <span class="text-amber-400">Hotel</span>Booking
            </a>

            <div class="hidden md:flex items-center gap-6 text-sm">
                <a href="{{ route('home') }}" class="hover:text-amber-400">Accueil</a>
                <a href="{{ route('hotels.index') }}" class="hover:text-amber-400">Hôtels</a>

                @auth
                    @if(auth()->user()->isClient())
                        <a href="{{ route('client.favoris') }}" class="hover:text-amber-400">Favoris</a>
                        <a href="{{ route('client.reservations.index') }}" class="hover:text-amber-400">Mes réservations</a>
                    @endif
                @endauth
            </div>

            <div class="flex items-center gap-4">
                @auth
                    <div class="relative group">
                        <button class="flex items-center gap-2">
                            <img src="{{ auth()->user()->avatarUrl() }}" class="w-8 h-8 rounded-full object-cover">
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white text-gray-800 rounded-lg shadow-xl border hidden group-hover:block">
                            @if(auth()->user()->isClient())
                                <a href="{{ route('client.profile.edit') }}" class="block px-4 py-2 text-sm hover:bg-gray-50">Mon profil</a>
                            @elseif(auth()->user()->isHotelier())
                                <a href="{{ route('hotelier.dashboard') }}" class="block px-4 py-2 text-sm hover:bg-gray-50">Tableau de bord</a>
                            @elseif(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm hover:bg-gray-50">Tableau de bord</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-50">Déconnexion</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-sm hover:text-amber-400">Connexion</a>
                    <a href="{{ route('register') }}" class="text-sm bg-amber-400 text-gray-900 px-4 py-2 rounded-lg font-semibold hover:bg-amber-500">Inscription</a>
                @endauth
            </div>
        </div>
    </nav>

    @if (session('success'))
        <div class="max-w-7xl mx-auto px-4 mt-4">
            <div class="bg-green-50 text-green-700 px-4 py-2 rounded-lg">{{ session('success') }}</div>
        </div>
    @endif

    <main>
        @yield('content')
    </main>

    <footer class="bg-gray-950 text-white/60 text-sm py-8 mt-10">
        <div class="max-w-7xl mx-auto px-4 text-center">
            © {{ date('Y') }} HotelBooking — Tous droits réservés.
        </div>
    </footer>
</body>
</html>
