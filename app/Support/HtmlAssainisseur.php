<?php

namespace App\Support;

/**
 * Nettoyage minimal du HTML produit par l'éditeur de texte enrichi (CKEditor),
 * utilisé partout où un champ passe d'un textarea brut à du contenu riche
 * (annonces, description d'hôtel, description de logement...).
 *
 * Liste blanche de balises de mise en forme uniquement, attributs actifs
 * neutralisés sur les liens. Pas de dépendance externe (aucun purificateur
 * HTML installé dans le projet) — volontairement strict plutôt que de
 * risquer une balise dangereuse.
 */
class HtmlAssainisseur
{
    private const BALISES_AUTORISEES = '<p><br><strong><b><em><i><u><s><a><ul><ol><li><h1><h2><h3><blockquote>';

    public static function nettoyer(?string $html): ?string
    {
        if ($html === null) {
            return null;
        }

        $propre = strip_tags($html, self::BALISES_AUTORISEES);

        // Retire tout attribut sauf href sur les liens, force target/rel, neutralise javascript:.
        return preg_replace_callback('/<a\s+([^>]*)>/i', function ($m) {
            preg_match('/href\s*=\s*"([^"]*)"/i', $m[1], $href);
            $url = $href[1] ?? '#';
            if (stripos($url, 'javascript:') === 0) {
                $url = '#';
            }
            return '<a href="' . e($url) . '" target="_blank" rel="noopener noreferrer">';
        }, $propre);
    }
}
