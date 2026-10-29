<?php

declare(strict_types=1);

use Juaniquillo\SvgBackendComponents\Builders\SvgComponentBuilder;
use Juaniquillo\SvgBackendComponents\SvgComponentEnum;

return SvgComponentBuilder::svg([
    SvgComponentBuilder::make(SvgComponentEnum::RECT)
        ->setAttributes(['x' => '10', 'y' => '10', 'width' => '80', 'height' => '50', 'rx' => '8', 'fill' => '#3b82f6']),
    SvgComponentBuilder::make(SvgComponentEnum::CIRCLE)
        ->setAttributes(['cx' => '140', 'cy' => '35', 'r' => '25', 'fill' => '#ef4444']),
    SvgComponentBuilder::make(SvgComponentEnum::ELLIPSE)
        ->setAttributes(['cx' => '50', 'cy' => '90', 'rx' => '35', 'ry' => '18', 'fill' => '#22c55e']),
    SvgComponentBuilder::make(SvgComponentEnum::LINE)
        ->setAttributes(['x1' => '110', 'y1' => '80', 'x2' => '180', 'y2' => '100', 'stroke' => '#111827', 'stroke-width' => '4']),
])
    ->setViewBox(0, 0, 200, 120)
    ->setSize(200, 120);
