<?php

declare(strict_types=1);

namespace Juaniquillo\SvgBackendComponents;

use Illuminate\Support\ServiceProvider;

class SvgBackendComponentsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'svg');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/svg'),
            ], 'svg-views');
        }
    }
}
