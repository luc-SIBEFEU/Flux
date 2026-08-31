<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Priorité : session (choix explicite pendant la navigation), sinon la préférence
        // enregistrée sur le compte de l'utilisateur connecté, sinon la langue par défaut.
        $locale = session('locale')
            ?? $request->user()?->locale
            ?? config('app.locale');

        // Vérifier que la locale est supportée
        if (!in_array($locale, ['fr', 'en'])) {
            $locale = config('app.locale');
        }
        
        // Définir la locale pour l'application
        app()->setLocale($locale);
        
        return $next($request);
    }
}
