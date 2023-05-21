<?php

namespace App\Services;

use Illuminate\Support\Facades\App;
use App\Enums\LanguageEnum;

class LanguageService
{
    /**
     * @param bool $all
     * @return array
     */
    public function availableLanguages(bool $all = false): array
    {
        $currentLanguage = $this->currentLanguage();
        $languages = collect(LanguageEnum::values());
        $availableLanguages = $all ? $languages : $languages->filter(fn (string $language) => $language !== $currentLanguage['value']);

        return $availableLanguages->map(fn (string $language) => $this->currentLanguage($language))->toArray();
    }

    /**
     * @param string|null $language
     * @return array
     */
    public function currentLanguage(?string $language = null): array
    {
        if(is_null($language)) {
            $language = App::getLocale();
        }

        return [
            'value' => $language,
            'label' => __("language.$language"),
            'url' => route('translate', compact('language')),
            'icon' => $language === LanguageEnum::English->value ? 'us' : $language,
        ];
    }
}
