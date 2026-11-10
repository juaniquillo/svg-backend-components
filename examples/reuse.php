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
                SvgComponentFactory::make(SvgComponentEnum::CIRCLE)
                    ->setAttributes(['id' => 'dot', 'r' => '15', 'fill' => '#06b6d4']),
            ]),
        SvgComponentFactory::make(SvgComponentEnum::G)
            ->setAttributes(['stroke' => '#111827', 'stroke-width' => '2'])
            ->setContents([
                SvgComponentFactory::make(SvgComponentEnum::TITLE)->setContent('Reused dots'),
                SvgComponentFactory::make(SvgComponentEnum::DESC)->setContent('The same circle, placed twice with use.'),
                SvgComponentFactory::make(SvgComponentEnum::USE)
                    ->setAttributes(['href' => '#dot', 'x' => '30', 'y' => '50']),
                SvgComponentFactory::make(SvgComponentEnum::USE)
                    ->setAttributes(['href' => '#dot', 'x' => '90', 'y' => '50']),
            ]),
    ]);
