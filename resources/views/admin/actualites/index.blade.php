@extends('layouts.dashboard')
@php($espaceRole = 'admin')
@section('titre_page', __('sidebar.actualites'))
@section('titre', __('sidebar.actualites') . ' — ' . __('sidebar.espace_admin'))

@section('contenu')

<div class="flex items-center justify-between mb-6 flex-wrap gap-3">
    <div class="flex gap-2 overflow-x-auto carte-scroll">
        @foreach(['' => __('reservation.tab_toutes'), 'en_cours'=>__('actualite.en_cours'), 'a_venir'=>__('actualite.a_venir'), 'passees'=>__('actualite.passees')] as $val=>$label)
            <a href="{{ route('admin.actualites.index', array_filter(['periode'=>$val])) }}"
               class="shrink-0 px-4 py-2 rounded-full text-sm font-medium border
                      {{ request('periode', '') === $val ? 'bg-flux-bleu text-white border-flux-bleu' : 'bg-white text-flux-noir/60 border-black/10' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>
    <a class="js-form-open-toggle button inline-flex items-center gap-2 bg-flux-bleu text-white text-sm font-medium px-4 py-2.5 rounded-lg"> {{-- href="{{ route('admin.actualites.create') }}" --}}
        <x-icon name="plus" class="w-4 h-4" /> {{ __('actualite.nouvelle_actualite') }}
    </a>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
    @foreach($actualites as $actu)
        <div class="bg-white border border-black/10 rounded-2xl overflow-hidden">
            <img src="{{ asset('storage/'.$actu->image) }}" class="w-full h-36 object-cover">
            <div class="p-5">
                <p class="text-xs text-flux-bleu font-medium">{{ $actu->date_debut->format('d/m/Y') }} — {{ $actu->date_fin->format('d/m/Y') }}</p>
                <h3 class="font-medium mt-1 mb-3">{{ $actu->nom }}</h3>
                <div class="flex gap-2">
                    <a href="{{ route('admin.actualites.edit', $actu) }}" class="inline-flex items-center gap-1.5 text-sm text-flux-bleu font-medium">
                        <x-icon name="pencil" class="w-4 h-4" /> {{ __('common.modifier') }}
                    </a>
                    <form action="{{ route('admin.actualites.destroy', $actu) }}" method="POST" onsubmit="return confirm('{{ __('actualite.confirmer_suppression') }}')">
                        @csrf @method('DELETE')
                        <button class="inline-flex items-center gap-1.5 text-sm text-red-500 font-medium">
                            <x-icon name="trash" class="w-4 h-4" /> {{ __('common.supprimer') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="mt-8">{{ $actualites->links() }}</div>



{{-- FORMULAIRE --}}

<div id="form-overlay" class="form-overlay fixed inset-0 bg-black/50 z-50 hidden"></div>
<div id="form" class="form fixed inset-0 z-50 hidden">        
    
    <form action="{{ $actualite->exists ? route('admin.actualites.update', $actualite) : route('admin.actualites.store') }}"
          method="POST" enctype="multipart/form-data" class="bg-white border border-black/10 rounded-2xl p-6 max-w-2xl space-y-5">
        @csrf
        @if($actualite->exists) @method('PUT') @endif
    <div class="flex items-center justify-between">
        <h2 class="font-height text-lg">{{ __('actualite.nouvelle_actualite') }}</h2>
        <a class="js-form-close-toggle hidden inline-flex items-center gap-2  text-flux-noir font-semibold px-6 py-3 rounded-lg button">
            x
        </a>
    </div>
    <div>
        <label class="text-xs font-medium text-flux-noir/50">{{ __('common.nom') }}</label>
        <input type="text" name="nom" required value="{{ old('nom', $actualite->nom) }}"
               class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
    </div>

    <div>
        <label class="text-xs font-medium text-flux-noir/50">{{ __('common.description') }}</label>
        <textarea name="description" rows="4" required
                  class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">{{ old('description', $actualite->description) }}</textarea>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="text-xs font-medium text-flux-noir/50">{{ __('actualite.date_debut') }}</label>
            <input type="date" name="date_debut" required value="{{ old('date_debut', optional($actualite->date_debut)->format('Y-m-d')) }}"
                   class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
        </div>
        <div>
            <label class="text-xs font-medium text-flux-noir/50">{{ __('actualite.date_fin') }}</label>
            <input type="date" name="date_fin" required value="{{ old('date_fin', optional($actualite->date_fin)->format('Y-m-d')) }}"
                   class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
        </div>
    </div>

    <div>
        <label class="text-xs font-medium text-flux-noir/50">{{ __('actualite.ordre_carrousel') }}</label>
        <input type="number" name="ordre" min="0" value="{{ old('ordre', $actualite->ordre ?? 0) }}"
               class="mt-1 w-32 border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
        <p class="text-xs text-flux-noir/40 mt-1">{{ __('actualite.ordre_desc') }}</p>
    </div>

    <div>
        <label class="text-xs font-medium text-flux-noir/50">{{ __('actualite.image') }}</label>
        @if($actualite->image)
            <img src="{{ asset('storage/'.$actualite->image) }}" class="w-32 h-20 object-cover rounded-lg mt-2 mb-2">
        @endif
        <input type="file" name="image" accept="image/*" class="mt-1 w-full text-sm">
    </div>

    <button type="submit" class="inline-flex items-center gap-2 bg-flux-bleu text-white font-semibold px-6 py-3 rounded-lg">
        {{ $actualite->exists ? __('form.enregistrer') : __('actualite.publier') }}
    </button>
</form>
<script src="{{ asset('js/admin.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        initForm();
    });
</script>
@endsection
