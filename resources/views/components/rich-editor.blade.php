@props(['name', 'value' => '', 'label' => null, 'rows' => 8])

{{--
    Éditeur de texte enrichi réutilisable, basé sur CKEditor (public/js/ckeditor.js,
    déjà vendorisé — aucune dépendance externe). Utilisation :

        <x-rich-editor name="contenu" :value="old('contenu', $annonce->contenu ?? '')" label="Contenu" />

    Le textarea reste le champ soumis au formulaire (CKEditor synchronise son
    contenu HTML dedans à chaque frappe) : aucun changement côté contrôleur.
--}}

@once
    <script src="{{ asset('js/ckeditor.js') }}"></script>
@endonce

<div>
    @if($label)
        <label for="{{ $name }}" class="text-xs font-medium text-flux-noir/50">{{ $label }}</label>
    @endif
    <textarea id="{{ $name }}" name="{{ $name }}" rows="{{ $rows }}"
        class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2 text-sm outline-none focus:border-flux-bleu">{{ $value }}</textarea>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const champ = document.getElementById('{{ $name }}');
            if (!champ || typeof ClassicEditor === 'undefined') return;

            ClassicEditor.create(champ, {
                // Seul le pack de langue anglais est inclus dans le build vendorisé
                // (public/js/ckeditor.js) : la locale de l'app ne s'applique qu'au
                // contenu saisi, pas à l'interface de l'éditeur.
                toolbar: [
                    'heading', '|', 'bold', 'italic', 'underline', '|',
                    'link', 'bulletedList', 'numberedList', 'blockQuote', '|',
                    'outdent', 'indent', '|', 'undo', 'redo',
                ],
            }).then(function (editor) {
                editor.model.document.on('change:data', function () {
                    champ.value = editor.getData();
                });
                // S'assure que la valeur est bien synchronisée juste avant l'envoi du formulaire.
                const form = champ.closest('form');
                if (form) {
                    form.addEventListener('submit', function () {
                        champ.value = editor.getData();
                    });
                }
            }).catch(function (erreur) {
                console.error('CKEditor:', erreur);
            });
        });
    </script>
@endpush
