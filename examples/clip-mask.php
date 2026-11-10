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
                SvgComponentFactory::make(SvgComponentEnum::CLIP_PATH)
                    ->setAttributes(['id' => 'round'])
                    ->setContents([
                        SvgComponentFactory::make(SvgComponentEnum::CIRCLE)
                            ->setAttributes(['cx' => '50', 'cy' => '50', 'r' => '40']),
                    ]),
                SvgComponentFactory::make(SvgComponentEnum::PATTERN)
                    ->setAttributes(['id' => 'dots', 'width' => '12', 'height' => '12', 'patternUnits' => 'userSpaceOnUse'])
                    ->setContents([
                        SvgComponentFactory::make(SvgComponentEnum::CIRCLE)
                            ->setAttributes(['cx' => '3', 'cy' => '3', 'r' => '2', 'fill' => '#3b82f6']),
                    ]),
            ]),
        SvgComponentFactory::make(SvgComponentEnum::RECT)
            ->setAttributes(['x' => '10', 'y' => '10', 'width' => '80', 'height' => '80', 'fill' => '#f97316', 'clip-path' => 'url(#round)']),
        SvgComponentFactory::make(SvgComponentEnum::RECT)
            ->setAttributes(['x' => '110', 'y' => '10', 'width' => '80', 'height' => '80', 'fill' => 'url(#dots)']),
    ]);
