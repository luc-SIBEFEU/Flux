@php
    $notifsRecentes = auth()->user()->notifications()->latest()->limit(8)->get();
    $nonLues = auth()->user()->unreadNotifications()->count();
@endphp

<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" @click.outside="open = false" class="relative p-2 text-flux-noir/40 hover:text-flux-noir" title="{{ __('notifications.titre') }}">
        <x-icon name="bell" class="w-5 h-5" />
        @if ($nonLues > 0)
            <span class="absolute -top-0.5 -right-0.5 min-w-[16px] h-4 px-1 rounded-full bg-red-500 text-white text-[10px] leading-4 text-center font-medium">
                {{ $nonLues > 9 ? '9+' : $nonLues }}
            </span>
        @endif
    </button>

    <div x-show="open" x-cloak x-transition
         class="absolute right-0 mt-2 w-80 max-h-96 overflow-y-auto bg-white rounded-xl shadow-xl border border-black/5 z-50">
        <div class="flex items-center justify-between px-4 py-3 border-b border-black/5">
            <span class="text-sm font-medium text-flux-noir">{{ __('notifications.titre') }}</span>
            @if ($nonLues > 0)
                <form method="POST" action="{{ route('notifications.tout-lire') }}">
                    @csrf
                    <button class="text-xs text-flux-bleu hover:underline">{{ __('notifications.tout_marquer_lu') }}</button>
                </form>
            @endif
        </div>

        @forelse ($notifsRecentes as $notification)
            <form method="POST" action="{{ route('notifications.lue', $notification->id) }}" class="block">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-3 border-b border-black/5 last:border-0 hover:bg-flux-brume flex gap-3 {{ $notification->read_at ? 'opacity-60' : '' }}">
                    <x-icon name="{{ $notification->data['icone'] ?? 'bell' }}" class="w-4 h-4 shrink-0 mt-0.5 text-flux-bleu" />
                    <span>
                        <span class="block text-sm font-medium text-flux-noir">{{ $notification->data['titre'] ?? '' }}</span>
                        <span class="block text-xs text-flux-noir/60 mt-0.5">{{ $notification->data['message'] ?? '' }}</span>
                        <span class="block text-[11px] text-flux-noir/40 mt-1">{{ $notification->created_at->diffForHumans() }}</span>
                    </span>
                </button>
            </form>
        @empty
            <p class="px-4 py-6 text-sm text-flux-noir/40 text-center">{{ __('notifications.aucune') }}</p>
        @endforelse
    </div>
</div>
