@extends('layouts.dashboard')
@php $espaceRole = 'admin'; @endphp
@section('titre_page', __('admin_annonces.titre'))
@section('titre', __('admin_annonces.titre') . ' — ' . __('sidebar.espace_admin'))

@section('contenu')

<p class="text-sm text-flux-noir/50 mb-6">{{ __('admin_annonces.gerer_annonces') }}</p>

<form method="GET" class="flex flex-wrap gap-3 mb-6">
    <select name="ville" onchange="this.form.submit()" class="border border-black/10 rounded-lg px-3 py-2.5 text-sm bg-white">
        <option value="">{{ __('common.tout') }} ({{ __('common.ville') }})</option>
        @foreach($villes as $ville)
            <option value="{{ $ville }}" {{ request('ville') == $ville ? 'selected' : '' }}>{{ $ville }}</option>
        @endforeach
    </select>
    <select name="statut" onchange="this.form.submit()" class="border border-black/10 rounded-lg px-3 py-2.5 text-sm bg-white">
        <option value="">{{ __('admin_annonces.tous_statuts') }}</option>
        <option value="visible" {{ request('statut')=='visible'?'selected':'' }}>{{ __('admin_annonces.visible') }}</option>
        <option value="masquee" {{ request('statut')=='masquee'?'selected':'' }}>{{ __('admin_annonces.masquee') }}</option>
    </select>
</form>

<div class="bg-white border border-black/10 rounded-2xl overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-flux-brume text-flux-noir/60 text-xs uppercase tracking-wide">
            <tr>
                <th class="text-left px-5 py-3">{{ __('annonces_page.titre_annonce') }}</th>
                <th class="text-left px-5 py-3">{{ __('admin_annonces.auteur') }}</th>
                <th class="text-left px-5 py-3">{{ __('common.ville') }}</th>
                <th class="text-left px-5 py-3">{{ __('annonces_page.categorie') }}</th>
                <th class="text-left px-5 py-3">{{ __('common.statut') }}</th>
                <th class="text-right px-5 py-3">{{ __('common.actions') }}</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-black/5">
            @forelse($annonces as $annonce)
                <tr>
                    <td class="px-5 py-3 font-medium">
                        <a href="{{ route('annonces.show', $annonce) }}" target="_blank" class="hover:text-flux-bleu">{{ $annonce->titre }}</a>
                    </td>
                    <td class="px-5 py-3">{{ $annonce->auteur->nom }} <span class="text-flux-noir/40">({{ __('admin_users.role_' . $annonce->auteur->role) }})</span></td>
                    <td class="px-5 py-3">{{ $annonce->ville }}</td>
                    <td class="px-5 py-3">{{ __('annonces_page.categorie_' . $annonce->categorie) }}</td>
                    <td class="px-5 py-3">
                        <span class="text-xs px-2.5 py-1 rounded-full font-medium {{ $annonce->visible ? 'bg-flux-bleu-pale text-flux-bleu' : 'bg-flux-noir/10 text-flux-noir/50' }}">
                            {{ $annonce->visible ? __('annonces_page.publiee') : __('admin_annonces.masquee') }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-right">
                        @if($annonce->visible)
                            <form action="{{ route('admin.annonces.masquer', $annonce) }}" method="POST" class="inline">
                                @csrf
                                <button class="text-xs text-red-500 font-medium hover:underline">{{ __('admin_annonces.masquer') }}</button>
                            </form>
                        @else
                            <form action="{{ route('admin.annonces.afficher', $annonce) }}" method="POST" class="inline">
                                @csrf
                                <button class="text-xs text-flux-bleu font-medium hover:underline">{{ __('admin_annonces.afficher') }}</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-5 py-10 text-center text-flux-noir/40">{{ __('admin_annonces.aucune_annonce') }}</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">{{ $annonces->links() }}</div>

@endsection
