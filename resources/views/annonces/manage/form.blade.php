@extends('layouts.dashboard')
@php $espaceRole = auth()->user()->role; @endphp
@section('titre_page', $annonce->exists ? __('annonces_page.modifier_annonce') : __('annonces_page.nouvelle_annonce'))
@section('titre', ($annonce->exists ? __('annonces_page.modifier_annonce') : __('annonces_page.nouvelle_annonce')) . ' — ' . __('sidebar.mon_espace'))

@section('contenu')

<a href="{{ route('annonces.manage.index') }}" class="text-sm text-flux-noir/50 hover:text-flux-or mb-4 inline-block">← {{ __('annonces_page.mes_annonces') }}</a>

<form method="POST" action="{{ $annonce->exists ? route('annonces.manage.update', $annonce) : route('annonces.manage.store') }}"
      enctype="multipart/form-data" class="bg-white border border-black/10 rounded-2xl p-6 max-w-2xl space-y-5">
    @csrf
    @if($annonce->exists) @method('PUT') @endif

    <div>
        <label class="text-xs font-medium text-flux-noir/50">{{ __('annonces_page.titre_annonce') }}</label>
        <input type="text" name="titre" value="{{ old('titre', $annonce->titre) }}" required
               class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2 text-sm outline-none focus:border-flux-or">
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="text-xs font-medium text-flux-noir/50">{{ __('common.ville') }}</label>
            <input type="text" name="ville" value="{{ old('ville', $annonce->ville) }}" required
                   class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2 text-sm outline-none focus:border-flux-or">
        </div>
        <div>
            <label class="text-xs font-medium text-flux-noir/50">{{ __('annonces_page.categorie') }}</label>
            <select name="categorie" class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2 text-sm outline-none bg-white">
                @foreach(['promotion','information','evenement','disponibilite','autre'] as $cat)
                    <option value="{{ $cat }}" {{ old('categorie', $annonce->categorie ?? 'information') == $cat ? 'selected' : '' }}>{{ __('annonces_page.categorie_' . $cat) }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <x-rich-editor name="contenu" :value="old('contenu', $annonce->contenu)" :label="__('contact.message')" />

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="text-xs font-medium text-flux-noir/50">{{ __('annonces_page.image_optionnelle') }}</label>
            <input type="file" name="image" accept="image/*"
                   class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2 text-sm outline-none">
        </div>
        <div>
            <label class="text-xs font-medium text-flux-noir/50">{{ __('annonces_page.expiration_optionnelle') }}</label>
            <input type="date" name="expire_le" value="{{ old('expire_le', optional($annonce->expire_le)->format('Y-m-d')) }}"
                   class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2 text-sm outline-none focus:border-flux-or">
        </div>
    </div>

    <button type="submit" class="w-full bg-flux-or hover:bg-flux-or-vif text-flux-noir font-semibold py-3 rounded-lg transition-colors">
        {{ $annonce->exists ? __('form.enregistrer') : __('annonces_page.publier_annonce') }}
    </button>
</form>

@endsection
