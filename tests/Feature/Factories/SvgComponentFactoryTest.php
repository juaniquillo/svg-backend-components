<?php

declare(strict_types=1);

use Juaniquillo\BackendComponents\Themes\DefaultThemeManager;
use Juaniquillo\BackendComponents\Themes\LocalThemeManager;
use Juaniquillo\SvgBackendComponents\Factories\SvgComponentFactory;
use Juaniquillo\SvgBackendComponents\Factories\SvgLocalThemeComponentFactory;
use Juaniquillo\SvgBackendComponents\SvgBackendComponent;
use Juaniquillo\SvgBackendComponents\SvgComponentEnum;

it('creates a component from the enum', function () {
    $component = SvgComponentFactory::make(SvgComponentEnum::PATH);

    expect($component)->toBeInstanceOf(SvgBackendComponent::class)
        ->and($component->getName())->toBe('path');
});

it('creates an svg root with the fluent helpers', function () {
    $component = SvgComponentFactory::make(SvgComponentEnum::SVG)
        ->setXmlns()
        ->setViewBox(0, 0, 24, 24)
        ->setSize(24)
        ->setContents([
            SvgComponentFactory::make(SvgComponentEnum::CIRCLE)->setAttribute('r', '10'),
        ]);

    expect($component)->toBeInstanceOf(SvgBackendComponent::class)
        ->and($component->getName())->toBe('svg')
        ->and($component->getAttribute('xmlns'))->toBe('http://www.w3.org/2000/svg')
        ->and($component->getAttribute('viewBox'))->toBe('0 0 24 24')
        ->and($component->getAttributes())->toBe([
            'xmlns' => 'http://www.w3.org/2000/svg',
            'viewBox' => '0 0 24 24',
            'width' => 24,
            'height' => 24,
        ])
        ->and($component->getContents())->toHaveCount(1);
});

it('accepts a custom xmlns uri', function () {
    $component = SvgComponentFactory::make(SvgComponentEnum::SVG)->setXmlns('custom');

    expect($component->getAttribute('xmlns'))->toBe('custom');
});

it('resolves local themes with the local theme factory', function () {
    $component = SvgLocalThemeComponentFactory::make(SvgComponentEnum::PATH);

    expect($component)->toBeInstanceOf(SvgBackendComponent::class)
        ->and($component->getThemeManager())->toBeInstanceOf(LocalThemeManager::class)
        ->and($component->getName())->toBe('path');
});

it('isolates default and local theme paths per manager', function () {
    $default = SvgComponentFactory::make(SvgComponentEnum::PATH);
    $local = SvgLocalThemeComponentFactory::make(SvgComponentEnum::PATH);

    expect($default->getThemeManager())->toBeInstanceOf(DefaultThemeManager::class)
        ->and($local->getThemeManager())->toBeInstanceOf(LocalThemeManager::class)
        ->and($local->getThemeManager()->getDefaultPath())->not->toBe($default->getThemeManager()->getDefaultPath());
});

it('compiles themes from the app local theme path', function () {
    $component = SvgLocalThemeComponentFactory::make(SvgComponentEnum::PATH)
        ->setTheme('color', 'success');

    $component->getThemeManager()->setDefaultPath(__DIR__.'/../../fixtures/views/_themes/tailwind');

    expect($component->compileTheme())->toBe('text-violet-900');
});

it('renders a factory component to html', function () {
    $component = SvgComponentFactory::make(SvgComponentEnum::SVG)
        ->setContents([
            SvgComponentFactory::make(SvgComponentEnum::CIRCLE)->setAttribute('r', '10'),
        ]);

    $this->blade('{{ $component }}', ['component' => $component])
        ->assertSee('<svg', false)
        ->assertSee('<circle', false)
        ->assertSee('r="10"', false);
});
