<?php

namespace MX13\Translatable\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $locale = $request->segment(1);
        if (in_array($locale, config('translatable.locales'))) {
            if (!Cookie::has('locale') || Cookie::get('locale') !== $locale) {
                Cookie::queue(Cookie::make('locale', $locale, 60 * 24, null, null));
            }

            App::setLocale($locale);
            return $next($request);
        } else {
            $locale = Cookie::get('locale')
                ?? substr($request->headers->get('accept_language'), 0, 2)
                ?? config('translatable.fallback_locale');
            $segments = $request->segments();

            array_unshift($segments, $locale);
            return redirect(implode('/', $segments));
        }
    }
}
