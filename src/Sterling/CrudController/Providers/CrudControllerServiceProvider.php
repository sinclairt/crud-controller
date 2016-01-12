<?php

namespace Sterling\CrudController\Providers;

use Illuminate\Support\ServiceProvider;

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
        $this->app->register('Sterling\MagicViews\MagicViewsServiceProvider');

        $this->app->register('Sterling\Responses\SterlingResponsesServiceProvider');
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