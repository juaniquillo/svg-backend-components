<?php

declare(strict_types=1);

use Juaniquillo\SvgBackendComponents\Builders\SvgComponentBuilder;
use Juaniquillo\SvgBackendComponents\SvgComponentEnum;

return SvgComponentBuilder::make(SvgComponentEnum::SVG)
    ->setAttributes([
        'xmlns' => 'http://www.w3.org/2000/svg',
        'viewBox' => '0 0 200 80',
        'width' => '200',
        'height' => '80',
    ])
    ->setContents([
        SvgComponentBuilder::make(SvgComponentEnum::TEXT)
            ->setAttributes(['x' => '100', 'y' => '35', 'text-anchor' => 'middle', 'font-size' => '20', 'fill' => '#111827'])
            ->setContents([
                'Hello, ',
                SvgComponentBuilder::make(SvgComponentEnum::TSPAN)
                    ->setAttributes(['font-weight' => 'bold', 'fill' => '#3b82f6'])
                    ->setContent('SVG'),
            ]),
    ]);
