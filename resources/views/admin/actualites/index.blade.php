@extends('layouts.dashboard')
@php($espaceRole = 'admin')
@section('titre_page', 'Actualités')
@section('titre', 'Actualités — Admin')

@section('contenu')

<div class="flex items-center justify-between mb-6 flex-wrap gap-3">
    <div class="flex gap-2 overflow-x-auto carte-scroll">
        @foreach(['' => 'Toutes', 'en_cours'=>'En cours', 'a_venir'=>'À venir', 'passees'=>'Passées'] as $val=>$label)
            <a href="{{ route('admin.actualites.index', array_filter(['periode'=>$val])) }}"
               class="shrink-0 px-4 py-2 rounded-full text-sm font-medium border
                      {{ request('periode', '') === $val ? 'bg-flux-bleu text-white border-flux-bleu' : 'bg-white text-flux-noir/60 border-black/10' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>
    <a href="{{ route('admin.actualites.create') }}" class="inline-flex items-center gap-2 bg-flux-bleu text-white text-sm font-medium px-4 py-2.5 rounded-lg">
        <x-icon name="plus" class="w-4 h-4" /> Nouvelle actualité
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
                        <x-icon name="pencil" class="w-4 h-4" /> Modifier
                    </a>
                    <form action="{{ route('admin.actualites.destroy', $actu) }}" method="POST" onsubmit="return confirm('Supprimer cette actualité ?')">
                        @csrf @method('DELETE')
                        <button class="inline-flex items-center gap-1.5 text-sm text-red-500 font-medium">
                            <x-icon name="trash" class="w-4 h-4" /> Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="mt-8">{{ $actualites->links() }}</div>
@endsection
