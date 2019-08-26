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
    public function translation()
    {
        return $this->hasOne(get_class() . 'Translation');
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
            $locale = config('translatable.locale');
        }

        $filteredTranslations = [];
        foreach ($translations as $key => $value) {
            if ($value) $filteredTranslations[$key] = $value;
        }

        $this->translation()->create(array_merge(['locale' => $locale], $filteredTranslations));
    }

    /**
     * @param array $translations
     * @return void
     * @throws \Exception
     */
    public function updateTranslation(array $translations): void
    {
        if ($this->translation()->first()) {
            $filteredTranslations = [];
            foreach ($translations as $key => $value) {
                if ($value) $filteredTranslations[$key] = $value;
            }
            empty($filteredTranslations) ?: $this->translation()->update($filteredTranslations);
        } else {
            $this->addTranslation($translations);
        }
    }

    protected function getTranslation(string $attribute): string
    {
        if (App::getLocale() === 'ar')

            return $this->translation->{$attribute} ?: '';

        return $this->attributes[$attribute] ?? '';
    }
}