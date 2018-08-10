<?php

namespace Ryandadeng\Securepayframe;

use Illuminate\Support\ServiceProvider;

class SecurePayFrameServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;


    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->loadViewsFrom(__DIR__ . '/views', 'securepayframe');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->handleConfig();
        //
//        include __DIR__.'/routes/web.php';
//        $this->app->make('Ryandadeng\Securepayframe\Controllers\SecurePayFrameController');
    }


    protected function handleConfig()
    {
        $packageConfig     = __DIR__ . '/config/securepayframe.php';
        $destinationConfig = config_path('securepayframe.php');
        $this->publishes([
            $packageConfig => $destinationConfig,
            __DIR__.'/views' => base_path('resources/views/securepayframe'),
        ]);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'securepayframe',
        ];
    }
}
