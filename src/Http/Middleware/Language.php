<?php

namespace MX13\Translatable\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $locale = $request->segment(1);
        if (in_array($locale, config('translatable.locales'))) {
            if (!session()->has('locale') || session()->get('locale') !== $locale) {
                session()->put('locale', $locale);
            }

            App::setLocale($locale);
            return $next($request);
        } else {
            $segments = $request->segments();
            $locale = session()->get('locale') ?? App::getLocale();

            array_unshift($segments, $locale);
            return redirect(implode('/', $segments));
        }
    }
}
