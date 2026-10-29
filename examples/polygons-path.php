<?php

declare(strict_types=1);

use Juaniquillo\SvgBackendComponents\Builders\SvgComponentBuilder;
use Juaniquillo\SvgBackendComponents\SvgComponentEnum;

return SvgComponentBuilder::svg(
    [
        SvgComponentBuilder::make(SvgComponentEnum::POLYLINE)
            ->setAttributes(['points' => '10,110 40,60 70,90 100,40', 'fill' => 'none', 'stroke' => '#8b5cf6', 'stroke-width' => '4']),
        SvgComponentBuilder::make(SvgComponentEnum::POLYGON)
            ->setAttributes(['points' => '130,100 150,60 170,100', 'fill' => '#f59e0b']),
        SvgComponentBuilder::make(SvgComponentEnum::PATH)
            ->setAttributes(['d' => 'M120 30 C 140 10, 170 10, 185 30', 'fill' => 'none', 'stroke' => '#111827', 'stroke-width' => '4']),
    ],
    [
        'viewBox' => '0 0 200 120',
        'width' => '200',
        'height' => '120',
    ],
);
