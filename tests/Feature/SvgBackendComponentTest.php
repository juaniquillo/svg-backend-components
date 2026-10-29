<?php

declare(strict_types=1);

use Juaniquillo\BackendComponents\Contracts\ContentsComponent;
use Juaniquillo\BackendComponents\Themes\DefaultThemeManager;
use Juaniquillo\SvgBackendComponents\SvgBackendComponent;
use Juaniquillo\SvgBackendComponents\SvgComponentEnum;

it('resolves a component name from the enum', function () {
    $component = new SvgBackendComponent(SvgComponentEnum::SVG);

    expect($component->getName())->toBe('svg');
});

it('accepts a raw string name', function () {
    $component = new SvgBackendComponent('path');

    expect($component->getName())->toBe('path');
});

it('builds from the static factory', function () {
    $component = SvgBackendComponent::make(SvgComponentEnum::PATH);

    expect($component)->toBeInstanceOf(SvgBackendComponent::class)
        ->and($component->getName())->toBe('path');
});

it('sets the viewBox from coordinates', function () {
    $component = (new SvgBackendComponent(SvgComponentEnum::SVG))->setViewBox(0, 0, 24, 24);

    expect($component->getAttribute('viewBox'))->toBe('0 0 24 24');
});

it('sets width and height with setSize', function () {
    $square = (new SvgBackendComponent(SvgComponentEnum::SVG))->setSize(24);

    expect($square->getAttributes())->toBe(['width' => 24, 'height' => 24]);

    $rectangle = (new SvgBackendComponent(SvgComponentEnum::SVG))->setSize(200, 100);

    expect($rectangle->getAttributes())->toBe(['width' => 200, 'height' => 100]);
});

it('uses the svg view namespace for the component path', function () {
    $component = new SvgBackendComponent(SvgComponentEnum::PATH);

    expect($component->getContext())->toBe('svg::')
        ->and($component->getComponentPath())->toBe('svg::.path')
        ->and($component->getViewPath())->toBe('svg::components.path');
});

it('drops the svg namespace for local resolution', function () {
    $component = (new SvgBackendComponent(SvgComponentEnum::RECT))->useLocal();

    expect($component->getNamespace())->toBeNull()
        ->and($component->getComponentPath())->toBe('rect');
});

it('appends a custom path to the component path', function () {
    $component = (new SvgBackendComponent(SvgComponentEnum::CIRCLE))->setPath('pro');

    expect($component->getPathOnly())->toBe('pro')
        ->and($component->getComponentPath())->toBe('svg::pro.circle');
});

it('keeps the svg context regardless of the namespace', function () {
    $component = (new SvgBackendComponent(SvgComponentEnum::G))->setNamespace('other');

    expect($component->getContext())->toBe('svg::')
        ->and($component->getComponentPath())->toBe('svg::.g');
});

it('accepts attributes', function () {
    $component = (new SvgBackendComponent(SvgComponentEnum::SVG))
        ->setAttribute('viewBox', '0 0 24 24');

    expect($component->getAttribute('viewBox'))->toBe('0 0 24 24')
        ->and($component->getAttributes())->toBe(['viewBox' => '0 0 24 24']);
});

it('accepts multiple attributes at once', function () {
    $component = (new SvgBackendComponent(SvgComponentEnum::PATH))
        ->setAttributes(['d' => 'M0 0h24v24H0z', 'fill' => 'none']);

    expect($component->getAttributes())->toBe(['d' => 'M0 0h24v24H0z', 'fill' => 'none']);
});

it('returns null for a missing attribute', function () {
    expect((new SvgBackendComponent(SvgComponentEnum::PATH))->getAttribute('missing'))->toBeNull();
});

it('accepts content', function () {
    $component = (new SvgBackendComponent(SvgComponentEnum::TEXT))
        ->setContent('Hello');

    expect($component->processContent())->toBeInstanceOf(ContentsComponent::class)
        ->and($component->processContent()->toArray())->toBe(['Hello']);
});

it('accepts keyed content', function () {
    $component = (new SvgBackendComponent(SvgComponentEnum::G))
        ->setContent('Hello', 'greeting');

    expect($component->getContent('greeting'))->toBe('Hello')
        ->and($component->processContent()->toArray())->toBe(['greeting' => 'Hello']);
});

it('accepts a batch of content', function () {
    $component = (new SvgBackendComponent(SvgComponentEnum::SVG))
        ->setContents(['Hello', 'World']);

    expect($component->getContents())->toBe(['Hello', 'World'])
        ->and($component->processContent()->toArray())->toBe(['Hello', 'World']);
});

it('nests components as content', function () {
    $component = (new SvgBackendComponent(SvgComponentEnum::SVG))
        ->setContents([
            (new SvgBackendComponent(SvgComponentEnum::CIRCLE))->setAttribute('r', '10'),
        ]);

    expect($component->getContents())->toHaveCount(1)
        ->and($component->getContents()[0])->toBeInstanceOf(SvgBackendComponent::class);
});

it('accepts settings', function () {
    $component = (new SvgBackendComponent(SvgComponentEnum::SVG))
        ->setSetting('foo', 'bar');

    expect($component->getSetting('foo'))->toBe('bar')
        ->and($component->getSettings())->toBe(['foo' => 'bar']);
});

it('builds themes', function () {
    $component = (new SvgBackendComponent(SvgComponentEnum::PATH))
        ->setTheme('color', 'success');

    expect($component->getTheme('color'))->toBe('success')
        ->and($component->getThemes())->toBe(['color' => 'success']);
});

it('accumulates theme variants for the same theme name', function () {
    $component = (new SvgBackendComponent(SvgComponentEnum::PATH))
        ->setTheme('color', 'success')
        ->setTheme('color', 'error');

    expect($component->getTheme('color'))->toBe(['success', 'error']);
});

it('overwrites a theme variant when requested', function () {
    $component = (new SvgBackendComponent(SvgComponentEnum::PATH))
        ->setTheme('color', 'success')
        ->setTheme('color', 'danger', overwrite: true);

    expect($component->getTheme('color'))->toBe('danger');
});

it('merges compiled themes into the attribute bag', function () {
    $component = (new SvgBackendComponent(SvgComponentEnum::PATH))
        ->setTheme('color', 'success');

    $component->getThemeManager()->setDefaultPath(__DIR__.'/../fixtures/views/_themes/tailwind');

    expect($component->compileTheme())->toBe('text-violet-900')
        ->and($component->getAttributeBag()->getAttributes())->toHaveKey('class', 'text-violet-900');
});

it('compiles to null when no themes are set', function () {
    expect((new SvgBackendComponent(SvgComponentEnum::PATH))->compileTheme())->toBeNull();
});

it('serializes the component to an array', function () {
    $component = (new SvgBackendComponent(SvgComponentEnum::CIRCLE))
        ->setAttribute('r', '10')
        ->setContent('Hello');

    $array = $component->toArray();

    expect($array)
        ->toHaveKey('name', 'circle')
        ->toHaveKey('attributes', ['r' => '10'])
        ->toHaveKey('content', ['Hello'])
        ->toHaveKey('path', 'svg::.circle')
        ->toHaveKey('settings', [])
        ->toHaveKey('theme.manager', DefaultThemeManager::class)
        ->toHaveKey('theme.themes', $component->getThemes())
        ->toHaveKey('theme.path', $component->getThemeManager()->getDefaultPath())
        ->toHaveKey('theme.realPath', $component->getThemeManager()->getThemePath());
});

it('serializes to json when cast to string', function () {
    $component = (new SvgBackendComponent(SvgComponentEnum::CIRCLE))
        ->setContent('Hello');

    expect((string) $component)->toBe(\json_encode($component->toArray()));
});

it('renders the svg element to html', function () {
    $component = (new SvgBackendComponent(SvgComponentEnum::SVG))
        ->setAttribute('viewBox', '0 0 24 24')
        ->setContents([
            (new SvgBackendComponent(SvgComponentEnum::PATH))->setAttribute('d', 'M0 0h24v24H0z'),
        ]);

    $this->blade('{{ $component }}', ['component' => $component])
        ->assertSee('<svg', false)
        ->assertSee('viewBox="0 0 24 24"', false)
        ->assertSee('<path', false)
        ->assertSee('d="M0 0h24v24H0z"', false);
});

it('renders any svg element to html', function () {
    $component = (new SvgBackendComponent(SvgComponentEnum::CIRCLE))
        ->setAttribute('r', '10');

    $this->blade('{{ $component }}', ['component' => $component])
        ->assertSee('<circle', false)
        ->assertSee('r="10"', false);
});

it('renders camelCase svg elements to html', function () {
    $component = (new SvgBackendComponent(SvgComponentEnum::LINEAR_GRADIENT))
        ->setAttribute('id', 'fade')
        ->setContents([
            (new SvgBackendComponent(SvgComponentEnum::STOP))
                ->setAttributes(['offset' => '0%', 'stop-color' => 'white']),
        ]);

    $this->blade('{{ $component }}', ['component' => $component])
        ->assertSee('<linearGradient', false)
        ->assertSee('id="fade"', false)
        ->assertSee('<stop', false)
        ->assertSee('offset="0%"', false);
});

it('renders a gradient fill referencing defs', function () {
    $component = (new SvgBackendComponent(SvgComponentEnum::SVG))
        ->setAttribute('viewBox', '0 0 100 100')
        ->setContents([
            (new SvgBackendComponent(SvgComponentEnum::DEFS))
                ->setContents([
                    (new SvgBackendComponent(SvgComponentEnum::LINEAR_GRADIENT))
                        ->setAttribute('id', 'fade'),
                ]),
            (new SvgBackendComponent(SvgComponentEnum::RECT))
                ->setAttributes(['width' => '100', 'height' => '100', 'fill' => 'url(#fade)']),
        ]);

    $this->blade('{{ $component }}', ['component' => $component])
        ->assertSee('<defs', false)
        ->assertSee('<linearGradient', false)
        ->assertSee('fill="url(#fade)"', false);
});
