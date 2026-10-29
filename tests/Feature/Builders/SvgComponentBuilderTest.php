<?php

declare(strict_types=1);

use Juaniquillo\BackendComponents\Themes\LocalThemeManager;
use Juaniquillo\SvgBackendComponents\Builders\SvgComponentBuilder;
use Juaniquillo\SvgBackendComponents\Builders\SvgLocalThemeComponentBuilder;
use Juaniquillo\SvgBackendComponents\SvgBackendComponent;
use Juaniquillo\SvgBackendComponents\SvgComponentEnum;

it('builds a component from the enum', function () {
    $component = SvgComponentBuilder::make(SvgComponentEnum::PATH);

    expect($component)->toBeInstanceOf(SvgBackendComponent::class)
        ->and($component->getName())->toBe('path');
});

it('resolves local themes with the local theme builder', function () {
    $component = SvgLocalThemeComponentBuilder::make(SvgComponentEnum::PATH);

    expect($component)->toBeInstanceOf(SvgBackendComponent::class)
        ->and($component->getThemeManager())->toBeInstanceOf(LocalThemeManager::class)
        ->and($component->getName())->toBe('path');
});

it('compiles themes from the app local theme path', function () {
    $component = SvgLocalThemeComponentBuilder::make(SvgComponentEnum::PATH)
        ->setTheme('color', 'success');

    $component->getThemeManager()->setDefaultPath(__DIR__.'/../../fixtures/views/_themes/tailwind');

    expect($component->compileTheme())->toBe('text-violet-900');
});

it('renders a builder component to html', function () {
    $component = SvgComponentBuilder::make(SvgComponentEnum::SVG)
        ->setContents([
            SvgComponentBuilder::make(SvgComponentEnum::CIRCLE)->setAttribute('r', '10'),
        ]);

    $this->blade('{{ $component }}', ['component' => $component])
        ->assertSee('<svg', false)
        ->assertSee('<circle', false)
        ->assertSee('r="10"', false);
});
