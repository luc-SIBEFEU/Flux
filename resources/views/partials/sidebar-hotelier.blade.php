@php
$liens = [
    ['route' => 'hotelier.dashboard', 'icone' => 'chart', 'label' => __('sidebar.tableau_de_bord')],
    ['route' => 'hotelier.hotels.index', 'icone' => 'building', 'label' => __('sidebar.mes_hotels')],
    ['route' => 'hotelier.reservations.index', 'icone' => 'calendar', 'label' => __('sidebar.reservations')],
    ['route' => 'hotelier.avis.index', 'icone' => 'star', 'label' => __('sidebar.avis_clients')],
    ['route' => 'hotelier.messages.index', 'icone' => 'mail', 'label' => __('sidebar.messages')],
    ['route' => 'forfait.index', 'icone' => 'sparkles', 'label' => __('sidebar.mon_forfait')],
    ['route' => 'hotelier.profil.edit', 'icone' => 'user', 'label' => __('sidebar.mon_profil')],
    ['route' => 'hotelier.aide.index', 'icone' => 'sparkles', 'label' => __('sidebar.guide_notice')],
];
@endphp

<div class="p-6">
    <a href="{{ route('accueil') }}" class="flex items-center gap-2 mb-8">
        <span class="w-9 h-9 rounded-full bg-flux-bleu-vif flex items-center justify-center">
            <x-icon name="sparkles" class="w-5 h-5 text-white" />
        </span>
        <div>
            <div class="font-display text-lg leading-none">Flux</div>
            <div class="text-xs text-white/40 mt-1">{{ __('sidebar.espace_hotelier') }}</div>
        </div>
    </a>

    <nav class="space-y-1">
        @foreach ($liens as $lien)
            <a href="{{ route($lien['route']) }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-colors
                      {{ request()->routeIs(explode('.',$lien['route'])[0].'.'.explode('.',$lien['route'])[1].'*') ? 'bg-flux-bleu-vif text-white font-medium' : 'text-white/70 hover:bg-white/10' }}">
                <x-icon name="{{ $lien['icone'] }}" class="w-5 h-5 shrink-0" />
                {{ $lien['label'] }}
            </a>
        @endforeach
    </nav>
</div>
