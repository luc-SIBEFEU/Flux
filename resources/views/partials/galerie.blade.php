{{--
    Partial galerie réutilisable.
    Variables attendues :
    - $model        : instance possédant la relation photos() (Hotel, CategorieChambre, Logement, Minicite)
    - $type         : 'hotel' | 'chambre' | 'logement' | 'minicite' (résolu par le PhotoController)
    - $routeStore   : route nommée pour l'upload (ex: route('hotelier.photos.store', [$type, $model->id]))
    - $routeDestroy : nom de route pour la suppression (ex: 'hotelier.photos.destroy')
    - $accent       : 'bleu' | 'violet' (couleur du bouton selon l'espace)
--}}
@php($accent = $accent ?? 'bleu')

<div class="bg-white border border-black/10 rounded-2xl p-6">
    <h3 class="font-medium mb-4 flex items-center gap-2">
        <x-icon name="camera" class="w-4 h-4 text-flux-{{ $accent }}" /> {{ __('galerie.galerie_photo') }}
    </h3>

    <div class="grid grid-cols-3 sm:grid-cols-4 gap-3 mb-4">
        @foreach($model->photos as $photo)
            <div class="relative group">
                <img src="{{ asset('storage/'.$photo->chemin) }}" class="w-full h-20 object-cover rounded-lg">
                <form action="{{ route($routeDestroy, $photo) }}" method="POST"
                      class="absolute top-1 right-1 opacity-0 group-hover:opacity-100 transition-opacity"
                      onsubmit="return confirm('{{ __('galerie.confirmer_suppression') }}')">
                    @csrf @method('DELETE')
                    <button class="w-6 h-6 rounded-full bg-red-500 text-white flex items-center justify-center">
                        <x-icon name="trash" class="w-3.5 h-3.5" />
                    </button>
                </form>
            </div>
        @endforeach
    </div>

    <form action="{{ $routeStore }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-3">
        @csrf
        <input type="file" name="photos[]" accept="image/*" multiple class="text-sm flex-1">
        <button class="inline-flex items-center gap-1.5 bg-flux-{{ $accent }} text-white text-sm font-medium px-4 py-2 rounded-lg shrink-0">
            <x-icon name="plus" class="w-4 h-4" /> {{ __('common.ajouter') }}
        </button>
    </form>
</div>
