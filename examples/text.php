<?php

declare(strict_types=1);

use Juaniquillo\SvgBackendComponents\Factories\SvgComponentFactory;
use Juaniquillo\SvgBackendComponents\SvgComponentEnum;

return SvgComponentFactory::make(SvgComponentEnum::SVG)
    ->setXmlns()
    ->setViewBox(0, 0, 200, 80)
    ->setSize(200, 80)
    ->setContents([
        SvgComponentFactory::make(SvgComponentEnum::TEXT)
            ->setAttributes(['x' => '100', 'y' => '35', 'text-anchor' => 'middle', 'font-size' => '20', 'fill' => '#111827'])
            ->setContents([
                'Hello, ',
                SvgComponentFactory::make(SvgComponentEnum::TSPAN)
                    ->setAttributes(['font-weight' => 'bold', 'fill' => '#3b82f6'])
                    ->setContent('SVG'),
            ]),
    ]);
