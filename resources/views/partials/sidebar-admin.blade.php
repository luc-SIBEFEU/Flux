@php
$liens = [
    ['route' => 'admin.dashboard', 'icone' => 'chart', 'label' => 'Tableau de bord'],
    ['route' => 'admin.actualites.index', 'icone' => 'bell', 'label' => 'Actualités'],
    ['route' => 'admin.hotels.index', 'icone' => 'building', 'label' => 'Hôtels à valider'],
    ['route' => 'admin.logements.index', 'icone' => 'key', 'label' => 'Logements à valider'],
    ['route' => 'admin.users.en-attente', 'icone' => 'user', 'label' => 'Comptes à valider'],
    ['route' => 'admin.users.index', 'icone' => 'users', 'label' => 'Clients, hôteliers & bailleurs'],
    ['route' => 'admin.avis.index', 'icone' => 'star', 'label' => 'Modération des avis'],
    ['route' => 'admin.rapports.index', 'icone' => 'coins', 'label' => 'Rapports financiers'],
    ['route' => 'admin.consultation.hotels', 'icone' => 'building', 'label' => 'Tous les hôtels'],
    ['route' => 'admin.consultation.logements', 'icone' => 'key', 'label' => 'Tous les logements'],
    ['route' => 'admin.consultation.bayes', 'icone' => 'users', 'label' => 'Tous les baux'],
    ['route' => 'admin.consultation.reservations', 'icone' => 'calendar', 'label' => 'Toutes les réservations'],
    ['route' => 'admin.aide.index', 'icone' => 'sparkles', 'label' => 'Guide & notice'],
];
@endphp

<div class="p-6 rounded-xl">
    <a href="{{ route('accueil') }}" class="flex items-center gap-2 mb-8">
        <span class="w-9 h-9 rounded-full bg-flux-or flex items-center justify-center">
            <x-icon name="sparkles" class="w-5 h-5 text-flux-noir" />
        </span>
        <div>
            <div class="font-display text-lg leading-none">Flux</div>
            <div class="text-xs text-white/40 mt-1">Espace admin</div>
        </div>
    </a>

    <nav class="space-y-1">
        @foreach ($liens as $lien)
            <a href="{{ route($lien['route']) }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-colors
                      {{ request()->routeIs(str_replace('.index','',$lien['route']).'*') || request()->routeIs($lien['route']) ? 'bg-flux-or text-flux-noir font-medium' : 'text-white/70 hover:bg-white/10' }}">
                <x-icon name="{{ $lien['icone'] }}" class="w-5 h-5 shrink-0" />
                {{ $lien['label'] }}
            </a>
        @endforeach
    </nav>
</div>
