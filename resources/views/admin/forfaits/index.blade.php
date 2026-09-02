@extends('layouts.dashboard')
@php $espaceRole = 'admin'; @endphp
@section('titre_page', __('sidebar.forfaits'))
@section('titre', __('sidebar.forfaits') . ' — ' . __('sidebar.espace_admin'))

@section('contenu')

<p class="text-sm text-flux-noir/60 mb-6">
    {{ __('admin_forfaits.intro') }}
</p>

<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
    @foreach ($forfaits as $forfait)
        <div class="bg-white border border-black/10 rounded-2xl p-6">
            <div class="flex items-center justify-between mb-4">
                <span class="font-display text-lg">{{ $forfait->nom }}</span>
                <span class="text-xs px-2.5 py-1 rounded-full font-medium {{ $forfait->type === 'free' ? 'bg-flux-noir/5 text-flux-noir/60' : 'bg-flux-bleu-pale text-flux-bleu' }}">
                    {{ __('admin_forfaits.type_' . $forfait->type) }}
                </span>
            </div>

            @if ($forfait->estFree())
                <p class="text-sm text-flux-noir/60">{{ __('admin_forfaits.gratuit_illimite') }}</p>
            @else
                <form method="POST" action="{{ route('admin.forfaits.update', $forfait) }}" class="space-y-3">
                    @csrf @method('PUT')

                    <label class="block text-xs text-flux-noir/50 font-medium">{{ __('common.nom') }}</label>
                    <input type="text" name="nom" value="{{ $forfait->nom }}" class="w-full border border-black/10 rounded-lg px-3 py-2 text-sm">

                    <label class="block text-xs text-flux-noir/50 font-medium">{{ __('admin_forfaits.prix_fcfa') }}</label>
                    <input type="number" step="0.01" name="prix" value="{{ $forfait->prix }}" class="w-full border border-black/10 rounded-lg px-3 py-2 text-sm">

                    <label class="block text-xs text-flux-noir/50 font-medium">{{ __('admin_forfaits.duree_jours') }}</label>
                    <input type="number" name="duree_jours" value="{{ $forfait->duree_jours }}" class="w-full border border-black/10 rounded-lg px-3 py-2 text-sm">

                    <label class="block text-xs text-flux-noir/50 font-medium">{{ __('common.description') }}</label>
                    <textarea name="description" rows="3" class="w-full border border-black/10 rounded-lg px-3 py-2 text-sm">{{ $forfait->description }}</textarea>

                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" name="actif" value="1" {{ $forfait->actif ? 'checked' : '' }}>
                        {{ __('admin_forfaits.formule_proposee') }}
                    </label>

                    <button class="w-full px-4 py-2.5 rounded-xl bg-flux-bleu-vif text-white text-sm font-medium">{{ __('form.enregistrer') }}</button>
                </form>
            @endif
        </div>
    @endforeach
</div>
@endsection
