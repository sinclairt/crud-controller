<?php

namespace Sinclair\CrudController\Providers;

use Illuminate\Support\ServiceProvider;
use Sinclair\MagicViews\MagicViewsServiceProvider;
use Sinclair\Responses\SinclairResponseServiceProvider;

class CrudControllerServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(MagicViewsServiceProvider::class);

        $this->app->register(SinclairResponseServiceProvider::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [ ];
    }
}