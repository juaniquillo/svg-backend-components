<?php

declare(strict_types=1);

use Juaniquillo\SvgBackendComponents\Factories\SvgComponentFactory;
use Juaniquillo\SvgBackendComponents\Shapes\SvgPath;
use Juaniquillo\SvgBackendComponents\Shapes\SvgShape;
use Juaniquillo\SvgBackendComponents\SvgComponentEnum;

return SvgComponentFactory::make(SvgComponentEnum::SVG)
    ->setXmlns()
    ->setViewBox(0, 0, 200, 120)
    ->setSize(200, 120)
    ->setContents([
        SvgShape::path(
            SvgPath::start(10, 100)
                ->lineTo(60, 40)
                ->lineToRelative(30, 30)
                ->horizontalLineTo(140)
                ->verticalLineTo(100)
                ->close()
        )->setFill('none')->setStroke('#8b5cf6')->setStrokeWidth(4),
        SvgShape::path(
            SvgPath::start(120, 30)->curveTo(140, 10, 170, 10, 185, 30)
        )->setFill('none')->setStroke('#111827')->setStrokeWidth(4),
    ]);
