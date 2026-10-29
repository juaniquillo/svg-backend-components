<?php

declare(strict_types=1);

use Juaniquillo\SvgBackendComponents\SvgBackendComponent;
use Juaniquillo\SvgBackendComponents\SvgComponentEnum;
use Juaniquillo\SvgBackendComponents\SvgRenderer;

it('renders a component to an svg string', function () {
    $svg = SvgRenderer::make(
        (new SvgBackendComponent(SvgComponentEnum::CIRCLE))->setAttribute('r', '10')
    )->toSvg();

    expect($svg)->toBe('<circle r="10"></circle>'."\n");
});

it('saves a component to a file', function () {
    $path = sys_get_temp_dir().'/svg-renderer-test-'.uniqid().'.svg';

    try {
        $written = SvgRenderer::make(
            (new SvgBackendComponent(SvgComponentEnum::PATH))->setAttribute('d', 'M0 0h24v24H0z')
        )->saveTo($path);

        expect($written)->toBe($path)
            ->and(file_get_contents($path))->toBe('<path d="M0 0h24v24H0z"></path>'."\n");
    } finally {
        if (file_exists($path)) {
            unlink($path);
        }
    }
});

it('creates missing parent directories when saving', function () {
    $directory = sys_get_temp_dir().'/svg-renderer-test-'.uniqid();
    $path = $directory.'/nested/icon.svg';

    try {
        SvgRenderer::make(new SvgBackendComponent(SvgComponentEnum::SVG))->saveTo($path);

        expect(file_exists($path))->toBeTrue();
    } finally {
        if (file_exists($path)) {
            unlink($path);
        }

        if (is_dir($directory.'/nested')) {
            rmdir($directory.'/nested');
        }

        if (is_dir($directory)) {
            rmdir($directory);
        }
    }
});
