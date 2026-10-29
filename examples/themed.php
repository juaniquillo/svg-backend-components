<?php

declare(strict_types=1);

use Juaniquillo\SvgBackendComponents\Builders\SvgComponentBuilder;
use Juaniquillo\SvgBackendComponents\Builders\SvgLocalThemeComponentBuilder;
use Juaniquillo\SvgBackendComponents\SvgComponentEnum;

$rect = SvgLocalThemeComponentBuilder::make(SvgComponentEnum::RECT)
    ->setAttributes(['x' => '10', 'y' => '10', 'width' => '80', 'height' => '80'])
    // Note: setTheme() only compiles to a class attribute (class="fill-sky-500").
    // Resolving that class into paint is your app's Tailwind build responsibility,
    // so this file renders as an unfilled rect until the theme file is covered by
    // your Tailwind content paths.
    ->setTheme('color', 'ocean');

$rect->getThemeManager()->setDefaultPath(__DIR__.'/themes/tailwind');

return SvgComponentBuilder::svg([$rect])
    ->setViewBox(0, 0, 100, 100)
    ->setSize(100);
