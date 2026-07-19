<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'Réservation Hôtelière'))</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-[#1b0a3f] via-[#3b1585] to-[#0d0620] min-h-screen text-gray-900 antialiased">

    <div class="max-w-7xl mx-auto px-4 py-6">
        <a href="{{ route('home') }}" class="text-xl font-bold text-white">
            🏨 <span class="text-amber-400">Hotel</span>Booking
        </a>
    </div>

    @yield('content')
</body>
</html>
