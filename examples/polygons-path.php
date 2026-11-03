<?php

declare(strict_types=1);

use Juaniquillo\SvgBackendComponents\Builders\SvgComponentBuilder;
use Juaniquillo\SvgBackendComponents\Shapes\SvgShape;
use Juaniquillo\SvgBackendComponents\SvgComponentEnum;

return SvgComponentBuilder::make(SvgComponentEnum::SVG)
    ->setXmlns()
    ->setViewBox(0, 0, 200, 120)
    ->setSize(200, 120)
    ->setContents([
        SvgShape::polyline('10,110 40,60 70,90 100,40')->setFill('none')->setStroke('#8b5cf6')->setStrokeWidth(4),
        SvgShape::polygon('130,100 150,60 170,100')->setFill('#f59e0b'),
        SvgShape::path('M120 30 C 140 10, 170 10, 185 30')->setFill('none')->setStroke('#111827')->setStrokeWidth(4),
    ]);
