<?php

declare(strict_types=1);

use Juaniquillo\SvgBackendComponents\Factories\SvgComponentFactory;
use Juaniquillo\SvgBackendComponents\Factories\SvgLocalThemeComponentFactory;
use Juaniquillo\SvgBackendComponents\SvgComponentEnum;

$rect = SvgLocalThemeComponentFactory::make(SvgComponentEnum::RECT)
    ->setAttributes(['x' => '10', 'y' => '10', 'width' => '80', 'height' => '80'])
    // Note: setTheme() only compiles to a class attribute (class="fill-slate-400").
    // Resolving that class into paint is your app's Tailwind build responsibility,
    // so this file renders as an unfilled rect until the theme file is covered by
    // your Tailwind content paths.
    ->setTheme('fill', 'muted');

$rect->getThemeManager()->setDefaultPath(__DIR__.'/themes/tailwind');

return SvgComponentFactory::make(SvgComponentEnum::SVG)
    ->setXmlns()
    ->setViewBox(0, 0, 100, 100)
    ->setSize(100)
    ->setContents([$rect]);
