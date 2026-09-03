@php
$liens = [
    ['route' => 'admin.dashboard', 'icone' => 'chart', 'label' => __('sidebar.tableau_de_bord')],
    ['route' => 'admin.actualites.index', 'icone' => 'bell', 'label' => __('sidebar.actualites')],
    ['route' => 'admin.contacts.index', 'icone' => 'phone', 'label' => __('sidebar.contacts')],
    ['route' => 'admin.hotels.index', 'icone' => 'building', 'label' => __('sidebar.hotels_a_valider')],
    ['route' => 'admin.logements.index', 'icone' => 'key', 'label' => __('sidebar.logements_a_valider')],
    ['route' => 'admin.users.en-attente', 'icone' => 'user', 'label' => __('sidebar.comptes_a_valider')],
    ['route' => 'admin.users.index', 'icone' => 'users', 'label' => __('sidebar.clients_hoteliers_bailleurs')],
    ['route' => 'admin.avis.index', 'icone' => 'star', 'label' => __('sidebar.moderation_avis')],
    ['route' => 'admin.annonces.index', 'icone' => 'megaphone', 'label' => __('admin_annonces.titre')],
    ['route' => 'admin.rapports.index', 'icone' => 'coins', 'label' => __('sidebar.rapports_financiers')],
    ['route' => 'admin.forfaits.index', 'icone' => 'sparkles', 'label' => __('sidebar.forfaits')],
    ['route' => 'admin.transferts.index', 'icone' => 'coins', 'label' => __('sidebar.reversements')],
    ['route' => 'admin.profil.edit', 'icone' => 'user', 'label' => __('sidebar.mon_profil')],
    ['route' => 'admin.consultation.hotels', 'icone' => 'building', 'label' => __('sidebar.tous_les_hotels')],
    ['route' => 'admin.consultation.logements', 'icone' => 'key', 'label' => __('sidebar.tous_les_logements')],
    ['route' => 'admin.consultation.bayes', 'icone' => 'users', 'label' => __('sidebar.tous_les_baux')],
    ['route' => 'admin.consultation.reservations', 'icone' => 'calendar', 'label' => __('sidebar.toutes_les_reservations')],
    ['route' => 'admin.aide.index', 'icone' => 'sparkles', 'label' => __('sidebar.guide_notice')],
];
@endphp

<div class="p-6 rounded-xl">
    <a href="{{ route('accueil') }}" class="flex items-center gap-2 mb-8">
        <span class="w-9 h-9 rounded-full bg-flux-or flex items-center justify-center">
            <x-icon name="sparkles" class="w-5 h-5 text-flux-noir" />
        </span>
        <div>
            <div class="font-display text-lg leading-none">Flux</div>
            <div class="text-xs text-white/40 mt-1">{{ __('sidebar.espace_admin') }}</div>
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
