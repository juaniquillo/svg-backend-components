<?php

declare(strict_types=1);

use Juaniquillo\SvgBackendComponents\Builders\SvgComponentBuilder;
use Juaniquillo\SvgBackendComponents\SvgComponentEnum;

return SvgComponentBuilder::svg(
    [
        SvgComponentBuilder::make(SvgComponentEnum::DEFS)
            ->setContents([
                SvgComponentBuilder::make(SvgComponentEnum::LINEAR_GRADIENT)
                    ->setAttributes(['id' => 'fade', 'x1' => '0', 'y1' => '0', 'x2' => '1', 'y2' => '0'])
                    ->setContents([
                        SvgComponentBuilder::make(SvgComponentEnum::STOP)
                            ->setAttributes(['offset' => '0%', 'stop-color' => '#3b82f6']),
                        SvgComponentBuilder::make(SvgComponentEnum::STOP)
                            ->setAttributes(['offset' => '100%', 'stop-color' => '#a855f7']),
                    ]),
                SvgComponentBuilder::make(SvgComponentEnum::RADIAL_GRADIENT)
                    ->setAttributes(['id' => 'glow'])
                    ->setContents([
                        SvgComponentBuilder::make(SvgComponentEnum::STOP)
                            ->setAttributes(['offset' => '0%', 'stop-color' => '#fde047']),
                        SvgComponentBuilder::make(SvgComponentEnum::STOP)
                            ->setAttributes(['offset' => '100%', 'stop-color' => '#f97316']),
                    ]),
            ]),
        SvgComponentBuilder::make(SvgComponentEnum::RECT)
            ->setAttributes(['x' => '10', 'y' => '10', 'width' => '85', 'height' => '80', 'fill' => 'url(#fade)']),
        SvgComponentBuilder::make(SvgComponentEnum::CIRCLE)
            ->setAttributes(['cx' => '150', 'cy' => '50', 'r' => '40', 'fill' => 'url(#glow)']),
    ],
    [
        'viewBox' => '0 0 200 100',
        'width' => '200',
        'height' => '100',
    ],
);
