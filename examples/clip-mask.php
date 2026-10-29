<?php

declare(strict_types=1);

use Juaniquillo\SvgBackendComponents\Builders\SvgComponentBuilder;
use Juaniquillo\SvgBackendComponents\SvgComponentEnum;

return SvgComponentBuilder::make(SvgComponentEnum::SVG)
    ->setAttributes([
        'xmlns' => 'http://www.w3.org/2000/svg',
        'viewBox' => '0 0 200 100',
        'width' => '200',
        'height' => '100',
    ])
    ->setContents([
        SvgComponentBuilder::make(SvgComponentEnum::DEFS)
            ->setContents([
                SvgComponentBuilder::make(SvgComponentEnum::CLIP_PATH)
                    ->setAttributes(['id' => 'round'])
                    ->setContents([
                        SvgComponentBuilder::make(SvgComponentEnum::CIRCLE)
                            ->setAttributes(['cx' => '50', 'cy' => '50', 'r' => '40']),
                    ]),
                SvgComponentBuilder::make(SvgComponentEnum::PATTERN)
                    ->setAttributes(['id' => 'dots', 'width' => '12', 'height' => '12', 'patternUnits' => 'userSpaceOnUse'])
                    ->setContents([
                        SvgComponentBuilder::make(SvgComponentEnum::CIRCLE)
                            ->setAttributes(['cx' => '3', 'cy' => '3', 'r' => '2', 'fill' => '#3b82f6']),
                    ]),
            ]),
        SvgComponentBuilder::make(SvgComponentEnum::RECT)
            ->setAttributes(['x' => '10', 'y' => '10', 'width' => '80', 'height' => '80', 'fill' => '#f97316', 'clip-path' => 'url(#round)']),
        SvgComponentBuilder::make(SvgComponentEnum::RECT)
            ->setAttributes(['x' => '110', 'y' => '10', 'width' => '80', 'height' => '80', 'fill' => 'url(#dots)']),
    ]);
