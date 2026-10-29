<?php

declare(strict_types=1);

namespace Juaniquillo\SvgBackendComponents\Tests;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ViewErrorBag;
use Juaniquillo\BackendComponents\BackendComponentsServiceProvider;
use Juaniquillo\SvgBackendComponents\SvgBackendComponentsServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        View::share('errors', new ViewErrorBag);
    }

    protected function getPackageProviders($app): array
    {
        return [
            BackendComponentsServiceProvider::class,
            SvgBackendComponentsServiceProvider::class,
        ];
    }
}
