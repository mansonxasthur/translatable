<?php
/**
 * User: Manson
 * Date: 11/29/2018
 * Time: 3:37 PM
 */

namespace MX13\Translatable;


use Illuminate\Support\ServiceProvider;

class TranslatableServiceProvider extends ServiceProvider
{
    const DS = DIRECTORY_SEPARATOR;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
         $this->publishes([
             __DIR__. self::DS . 'config' . self::DS . 'translatable.php' => config_path('translatable.php'),
         ]);
    }
}