<?php

declare(strict_types=1);

use Juaniquillo\SvgBackendComponents\Factories\SvgComponentFactory;
use Juaniquillo\SvgBackendComponents\SvgComponentEnum;

return SvgComponentFactory::make(SvgComponentEnum::SVG)
    ->setXmlns()
    ->setViewBox(0, 0, 200, 100)
    ->setSize(200, 100)
    ->setContents([
        SvgComponentFactory::make(SvgComponentEnum::DEFS)
            ->setContents([
                SvgComponentFactory::make(SvgComponentEnum::LINEAR_GRADIENT)
                    ->setAttributes(['id' => 'fade', 'x1' => '0', 'y1' => '0', 'x2' => '1', 'y2' => '0'])
                    ->setContents([
                        SvgComponentFactory::make(SvgComponentEnum::STOP)
                            ->setAttributes(['offset' => '0%', 'stop-color' => '#3b82f6']),
                        SvgComponentFactory::make(SvgComponentEnum::STOP)
                            ->setAttributes(['offset' => '100%', 'stop-color' => '#a855f7']),
                    ]),
                SvgComponentFactory::make(SvgComponentEnum::RADIAL_GRADIENT)
                    ->setAttributes(['id' => 'glow'])
                    ->setContents([
                        SvgComponentFactory::make(SvgComponentEnum::STOP)
                            ->setAttributes(['offset' => '0%', 'stop-color' => '#fde047']),
                        SvgComponentFactory::make(SvgComponentEnum::STOP)
                            ->setAttributes(['offset' => '100%', 'stop-color' => '#f97316']),
                    ]),
            ]),
        SvgComponentFactory::make(SvgComponentEnum::RECT)
            ->setAttributes(['x' => '10', 'y' => '10', 'width' => '85', 'height' => '80', 'fill' => 'url(#fade)']),
        SvgComponentFactory::make(SvgComponentEnum::CIRCLE)
            ->setAttributes(['cx' => '150', 'cy' => '50', 'r' => '40', 'fill' => 'url(#glow)']),
    ]);
