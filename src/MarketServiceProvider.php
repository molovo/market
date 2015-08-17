<?php

namespace Molovo\Market;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class MarketServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // use this if your package has views
        $this->loadViewsFrom(realpath(__DIR__.'/resources/views'), 'market');

        // use this if your package has routes
        $this->setupRoutes($this->app->router);

        // use this if your package needs a config file
        $this->publishes([
            __DIR__.'/config/config.php' => config_path('market.php'),
        ]);

        // use the vendor configuration file as fallback
        $this->mergeConfigFrom(
            __DIR__.'/config/config.php', 'market'
        );

        $this->publishes( [
            __DIR__.'/resources/assets/dist' => public_path( 'vendor/molovo/market' )
        ], 'public' );
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function setupRoutes(Router $router)
    {
        $router->group( [ 'namespace' => 'Molovo\Market\Http\Controllers' ], function( $router )
        {
            require __DIR__.'/Http/routes.php';
        } );
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerMarket();

        // use this if your package has a config file
        config([
                'config/market.php',
        ]);
    }

    private function registerMarket()
    {
        $this->app->bind('market',function($app){
            return new Market($app);
        });
    }
}