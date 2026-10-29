<?php

declare(strict_types=1);

/*
 * Renders every example in this directory to examples/output/<name>.svg.
 *
 * Run it with: composer examples
 */

use Juaniquillo\SvgBackendComponents\SvgBackendComponent;
use Juaniquillo\SvgBackendComponents\SvgRenderer;
use Orchestra\Testbench\Foundation\Application;
use Orchestra\Testbench\Foundation\Config;

require __DIR__.'/../vendor/autoload.php';

Application::createFromConfig(Config::loadFromYaml(__DIR__.'/..'));

$outputDir = __DIR__.'/output';

$files = glob(__DIR__.'/*.php') ?: [];

foreach ($files as $file) {
    if (basename($file) === 'render.php') {
        continue;
    }

    $component = require $file;

    if (! $component instanceof SvgBackendComponent) {
        fwrite(STDERR, 'Skipping '.basename($file).": file must return an SvgBackendComponent instance.\n");

        exit(1);
    }

    $name = pathinfo($file, PATHINFO_FILENAME);

    echo 'Rendered '.SvgRenderer::make($component)->saveTo($outputDir.'/'.$name.'.svg')."\n";
}
