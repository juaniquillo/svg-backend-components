<?php

declare(strict_types=1);

namespace Juaniquillo\SvgBackendComponents\Shapes;

use Juaniquillo\SvgBackendComponents\Contracts\SvgShapeFactory;
use Juaniquillo\SvgBackendComponents\Factories\SvgComponentFactory;
use Juaniquillo\SvgBackendComponents\SvgBackendComponent;
use Juaniquillo\SvgBackendComponents\SvgComponentEnum;
use Override;
use Stringable;

final class SvgShape implements SvgShapeFactory
{
    #[Override]
    public static function rect(int|string $x, int|string $y, int|string $width, int|string $height): SvgBackendComponent
    {
        return SvgComponentFactory::make(SvgComponentEnum::RECT)
            ->setAttributes(['x' => $x, 'y' => $y, 'width' => $width, 'height' => $height]);
    }

    #[Override]
    public static function circle(int|string $cx, int|string $cy, int|string $r): SvgBackendComponent
    {
        return SvgComponentFactory::make(SvgComponentEnum::CIRCLE)
            ->setAttributes(['cx' => $cx, 'cy' => $cy, 'r' => $r]);
    }

    #[Override]
    public static function ellipse(int|string $cx, int|string $cy, int|string $rx, int|string $ry): SvgBackendComponent
    {
        return SvgComponentFactory::make(SvgComponentEnum::ELLIPSE)
            ->setAttributes(['cx' => $cx, 'cy' => $cy, 'rx' => $rx, 'ry' => $ry]);
    }

    #[Override]
    public static function line(int|string $x1, int|string $y1, int|string $x2, int|string $y2): SvgBackendComponent
    {
        return SvgComponentFactory::make(SvgComponentEnum::LINE)
            ->setAttributes(['x1' => $x1, 'y1' => $y1, 'x2' => $x2, 'y2' => $y2]);
    }

    #[Override]
    public static function polyline(string $points): SvgBackendComponent
    {
        return SvgComponentFactory::make(SvgComponentEnum::POLYLINE)
            ->setAttribute('points', $points);
    }

    #[Override]
    public static function polygon(string $points): SvgBackendComponent
    {
        return SvgComponentFactory::make(SvgComponentEnum::POLYGON)
            ->setAttribute('points', $points);
    }

    #[Override]
    public static function path(string|Stringable $d): SvgBackendComponent
    {
        return SvgComponentFactory::make(SvgComponentEnum::PATH)
            ->setAttribute('d', (string) $d);
    }
}
