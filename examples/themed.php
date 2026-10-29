<?php

declare(strict_types=1);

use Juaniquillo\SvgBackendComponents\Builders\SvgComponentBuilder;
use Juaniquillo\SvgBackendComponents\Builders\SvgLocalThemeComponentBuilder;
use Juaniquillo\SvgBackendComponents\SvgComponentEnum;

$rect = SvgLocalThemeComponentBuilder::make(SvgComponentEnum::RECT)
    ->setAttributes(['x' => '10', 'y' => '10', 'width' => '80', 'height' => '80'])
    ->setTheme('color', 'ocean');

$rect->getThemeManager()->setDefaultPath(__DIR__.'/themes/tailwind');

return SvgComponentBuilder::make(SvgComponentEnum::SVG)
    ->setAttributes([
        'xmlns' => 'http://www.w3.org/2000/svg',
        'viewBox' => '0 0 100 100',
        'width' => '100',
        'height' => '100',
    ])
    ->setContents([$rect]);
