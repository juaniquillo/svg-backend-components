<?php

declare(strict_types=1);

use Juaniquillo\SvgBackendComponents\Builders\SvgComponentBuilder;
use Juaniquillo\SvgBackendComponents\SvgComponentEnum;

return SvgComponentBuilder::svg(
    [
        SvgComponentBuilder::make(SvgComponentEnum::TEXT)
            ->setAttributes(['x' => '100', 'y' => '35', 'text-anchor' => 'middle', 'font-size' => '20', 'fill' => '#111827'])
            ->setContents([
                'Hello, ',
                SvgComponentBuilder::make(SvgComponentEnum::TSPAN)
                    ->setAttributes(['font-weight' => 'bold', 'fill' => '#3b82f6'])
                    ->setContent('SVG'),
            ]),
    ],
    [
        'viewBox' => '0 0 200 80',
        'width' => '200',
        'height' => '80',
    ],
);
