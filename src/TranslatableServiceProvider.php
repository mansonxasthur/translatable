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
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app['router']->aliasMiddleware('locale', \MX13\Translatable\Http\Middleware\Locale::class);

        $this->mergeConfigFrom(
            __DIR__ . '/config/translatable.php', 'translatable'
        );
    }
        /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/routes.php');
         $this->publishes([
             __DIR__. '/config/translatable.php' => config_path('translatable.php'),
         ], 'config');
    }
}