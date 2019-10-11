<?php
/**
 * User: Manson
 * Date: 11/29/2018
 * Time: 2:59 PM
 */

namespace MX13\Translatable\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LocaleController
{
    public function changeLocale(Request $request, string $locale)
    {
        if (in_array($locale, config('translatable.locales'))) {
            $referer = $request->headers->get('referer');
            $currentLocale = App::getLocale();
            $redirectTo = str_replace($currentLocale, $locale, $referer);
            return redirect($redirectTo);
        }

        return redirect()->back();
    }
}