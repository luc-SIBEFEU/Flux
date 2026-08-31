<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titre', __('layouts.app.title'))</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('icons/bootstrap-icons.css') }}">
    <script defer src="{{ asset('js/cdn.min.js') }}"></script>
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="min-h-screen flex flex-col antialiased">
    @include('partials.navbar')

    @if (session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="flex items-center gap-2 bg-flux-bleu-pale text-flux-bleu px-4 py-3 rounded-xl text-sm">
                <x-icon name="check-circle" class="w-5 h-5 shrink-0" /> {{ session('success') }}
            </div>
        </div>
    @endif
    @if ($errors->any())
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="flex items-start gap-2 bg-red-50 text-red-700 px-4 py-3 rounded-xl text-sm">
                <x-icon name="x-circle" class="w-5 h-5 shrink-0 mt-0.5" />
                <ul class="space-y-1">
                    @foreach ($errors->all() as $erreur)
                        <li>{{ $erreur }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <main class="flex-1">
        @yield('contenu')
    </main>

    @include('partials.footer')

    @stack('scripts')
</body>
</html>
