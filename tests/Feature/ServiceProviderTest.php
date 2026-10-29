<?php

declare(strict_types=1);

use Juaniquillo\SvgBackendComponents\SvgBackendComponentsServiceProvider;

it('registers and boots the svg backend components provider', function () {
    $provider = $this->app->getProvider(SvgBackendComponentsServiceProvider::class);

    expect($provider)->toBeInstanceOf(SvgBackendComponentsServiceProvider::class);

    $loadedProviders = $this->app->getLoadedProviders();

    expect($loadedProviders[SvgBackendComponentsServiceProvider::class] ?? false)->toBeTrue();
});

it('registers the svg view namespace', function () {
    expect(view()->exists('svg::components.svg'))->toBeTrue()
        ->and(view()->exists('svg::components.path'))->toBeTrue()
        ->and(view()->exists('svg::components.linearGradient'))->toBeTrue()
        ->and(view()->exists('svg::components.clipPath'))->toBeTrue()
        ->and(view()->exists('svg::_utilities.resolve-component'))->toBeTrue();
});
