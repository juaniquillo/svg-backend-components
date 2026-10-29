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
                SvgComponentBuilder::make(SvgComponentEnum::CIRCLE)
                    ->setAttributes(['id' => 'dot', 'r' => '15', 'fill' => '#06b6d4']),
            ]),
        SvgComponentBuilder::make(SvgComponentEnum::G)
            ->setAttributes(['stroke' => '#111827', 'stroke-width' => '2'])
            ->setContents([
                SvgComponentBuilder::make(SvgComponentEnum::TITLE)->setContent('Reused dots'),
                SvgComponentBuilder::make(SvgComponentEnum::DESC)->setContent('The same circle, placed twice with use.'),
                SvgComponentBuilder::make(SvgComponentEnum::USE)
                    ->setAttributes(['href' => '#dot', 'x' => '30', 'y' => '50']),
                SvgComponentBuilder::make(SvgComponentEnum::USE)
                    ->setAttributes(['href' => '#dot', 'x' => '90', 'y' => '50']),
            ]),
    ]);
