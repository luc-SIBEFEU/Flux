@php
$liens = [
    ['route' => 'client.reservations.index', 'icone' => 'calendar', 'label' => __('sidebar.mes_reservations')],
    ['route' => 'client.favoris.index', 'icone' => 'heart', 'label' => __('sidebar.mes_favoris')],
    ['route' => 'client.bayes.index', 'icone' => 'key', 'label' => __('sidebar.mes_locations')],
    ['route' => 'client.profil.edit', 'icone' => 'user', 'label' => __('sidebar.mon_profil')],
    ['route' => 'client.aide.index', 'icone' => 'sparkles', 'label' => __('sidebar.guide_notice')],
];
@endphp

<div class="p-6">
    <a href="{{ route('accueil') }}" class="flex items-center gap-2 mb-8">
        <span class="w-9 h-9 rounded-full bg-flux-bleu-vif flex items-center justify-center">
            <x-icon name="sparkles" class="w-5 h-5 text-white" />
        </span>
        <div>
            <div class="font-display text-lg leading-none">Flux</div>
            <div class="text-xs text-white/40 mt-1">{{ __('sidebar.mon_espace') }}</div>
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
