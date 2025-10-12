<?php

namespace App\Providers;

use Illuminate\Translation\FileLoader;
use Modules\Language\Models\Language;

class CustomTranslationLoader extends FileLoader
{
    public function load($locale, $group, $namespace = null)
    {
        $fileTranslations = parent::load($locale, $group, $namespace);

        try {
            $databaseTranslations = \Modules\Language\Models\Language::getAllLang()->where('language', $locale)
            ->where('file', $group)
            ->pluck('value', 'key')
            ->toArray();
        } catch (\Throwable $th) {
            $databaseTranslations = [];
        }

        return array_merge($fileTranslations, $databaseTranslations);
    }
}
