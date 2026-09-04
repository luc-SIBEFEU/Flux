<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $translator = app('translator');

        foreach (['en', 'fr'] as $locale) {
            $path = resource_path("lang/{$locale}.json");

            if (! is_file($path)) {
                continue;
            }

            $translations = json_decode(file_get_contents($path), true, 512, JSON_THROW_ON_ERROR);
            $translator->addLines($this->flattenTranslations($translations), $locale);
        }
    }

    private function flattenTranslations(array $translations, string $prefix = ''): array
    {
        $flattened = [];

        foreach ($translations as $key => $value) {
            $translationKey = $prefix === '' ? $key : "{$prefix}.{$key}";

            if (is_array($value)) {
                $flattened += $this->flattenTranslations($value, $translationKey);
            } else {
                $flattened[$translationKey] = $value;
            }
        }

        return $flattened;
    }
}
