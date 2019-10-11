<?php
/**
 * Created by PhpStorm.
 * admin: Manson
 * Date: 2/1/2019
 * Time: 5:40 PM
 */

namespace MX13\Translatable\Http\Traits;

use Illuminate\Support\Facades\App;

trait Translatable
{
    /**
     * Set has many relationship for the called eloquent model
     *
     * @return mixed
     */
    public function translations()
    {
        $locales = config('translatable.locales');
        $fallback_locale = config('translatable.fallback_local');
        unset($locales[$fallback_locale]);
        $translations_count = count($locales);
        if ($translations_count === 1) {
            return $this->hasOne(get_class() . 'Translation');
        } else {
            return $this->hasMany(get_class(), 'Translation');
        }
    }

    /**
     * @param array $translations
     * @param string $locale
     * @return void
     * @throws \Exception
     */
    public function addTranslation(array $translations, string $locale = null): void
    {
        if ($locale) {
            if (!in_array($locale, config('translatable.locales')))
                throw new \Exception('Undefined locale');
        } else {
            $locale = config('translatable.default');
        }

        $filteredTranslations = [];
        foreach ($translations as $key => $value) {
            if ($value) $filteredTranslations[$key] = $value;
        }

        $this->translations()->create(array_merge(['locale' => $locale], $filteredTranslations));
    }

    /**
     * @param array $translations
     * @param string|null $locale
     *
     * @return void
     * @throws \Exception
     */
    public function updateTranslation(array $translations, string $locale = null): void
    {
        $locale = $locale ?: config('translatable.default');
        $translation = $this->translations()->where('locale', $locale)->first();
        if ($translation) {
            $filteredTranslations = [];
            foreach ($translations as $key => $value) {
                if ($value) $filteredTranslations[$key] = $value;
            }
            empty($filteredTranslations) ?: $translation->update($filteredTranslations);
        } else {
            $this->addTranslation($translations);
        }
    }

    protected function getTranslation(string $attribute): ?string
    {
        $appLocale = App::getLocale();
        if ($appLocale !== config('translatable.fallback_local')) {
            $translation = $this->translations()->where('locale', $appLocale)->first();
            return $translation ? $translation->{$attribute} : null;
        }

        return $this->attributes[$attribute];
    }
}