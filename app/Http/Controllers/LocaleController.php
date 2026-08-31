<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocaleController extends Controller
{
    /**
     * Changer la langue de l'application.
     */
    public function setLocale(Request $request, string $locale)
    {
        // Vérifier que la locale est supportée
        if (!in_array($locale, ['fr', 'en'])) {
            abort(404);
        }
        
        // Sauvegarder la locale dans la session
        session(['locale' => $locale]);
        
        // Rediriger vers la page précédente ou l'accueil
        return back()->with('success', $locale === 'fr' 
            ? 'Langue changée en français.' 
            : 'Language changed to English.'
        );
    }
}
