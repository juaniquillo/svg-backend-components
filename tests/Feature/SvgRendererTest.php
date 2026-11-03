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

it('injects xmlns on save when the root lacks it', function () {
    $path = sys_get_temp_dir().'/svg-renderer-test-'.uniqid().'.svg';
    $component = (new SvgBackendComponent(SvgComponentEnum::SVG))->setViewBox(0, 0, 24, 24);

    try {
        SvgRenderer::make($component)->saveTo($path);

        expect(file_get_contents($path))
            ->toBe('<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"></svg>'."\n")
            ->and($component->getAttribute('xmlns'))->toBeNull();
    } finally {
        if (file_exists($path)) {
            unlink($path);
        }
    }
});

it('keeps an existing xmlns untouched on save', function () {
    $path = sys_get_temp_dir().'/svg-renderer-test-'.uniqid().'.svg';

    try {
        SvgRenderer::make(
            (new SvgBackendComponent(SvgComponentEnum::SVG))->setXmlns('custom')
        )->saveTo($path);

        $contents = (string) file_get_contents($path);

        expect($contents)->toContain('xmlns="custom"')
            ->and(substr_count($contents, 'xmlns'))->toBe(1);
    } finally {
        if (file_exists($path)) {
            unlink($path);
        }
    }
});

it('prepends the xml prolog when requested', function () {
    $component = (new SvgBackendComponent(SvgComponentEnum::CIRCLE))->setAttribute('r', '10');

    expect(SvgRenderer::make($component)->toSvg(prolog: true))
        ->toBe('<?xml version="1.0" encoding="UTF-8"?>'."\n".'<circle r="10"></circle>'."\n");

    $path = sys_get_temp_dir().'/svg-renderer-test-'.uniqid().'.svg';

    try {
        SvgRenderer::make($component)->saveTo($path, prolog: true);

        expect(str_starts_with((string) file_get_contents($path), '<?xml version="1.0" encoding="UTF-8"?>'."\n"))->toBeTrue();
    } finally {
        if (file_exists($path)) {
            unlink($path);
        }
    }
});

it('throws when the target is unwritable', function () {
    $blocker = tempnam(sys_get_temp_dir(), 'svg-renderer-test-');

    try {
        SvgRenderer::make(new SvgBackendComponent(SvgComponentEnum::SVG))
            ->saveTo($blocker.'/icon.svg');
    } catch (RuntimeException $exception) {
        expect($exception->getMessage())->toContain($blocker);

        return;
    } finally {
        if (file_exists($blocker)) {
            unlink($blocker);
        }
    }

    $this->fail('Expected a RuntimeException for an unwritable target.');
});
