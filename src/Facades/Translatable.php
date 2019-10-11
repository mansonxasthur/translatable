<?php


namespace MX13\Translatable\Facades;


use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Facade;

class Translatable extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'translatable';
    }

    public static function setLocale()
    {
        $firstSegment = request()->segments(1);
        return array_shift($firstSegment) ?? Cookie::get('locale') ?? config('translatable.fallback_local');
    }
}