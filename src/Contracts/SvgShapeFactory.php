<?php

declare(strict_types=1);

namespace Juaniquillo\SvgBackendComponents\Contracts;

use Juaniquillo\SvgBackendComponents\SvgBackendComponent;
use Stringable;

interface SvgShapeFactory
{
    public static function rect(int|string $x, int|string $y, int|string $width, int|string $height): SvgBackendComponent;

    public static function circle(int|string $cx, int|string $cy, int|string $r): SvgBackendComponent;

    public static function ellipse(int|string $cx, int|string $cy, int|string $rx, int|string $ry): SvgBackendComponent;

    public static function line(int|string $x1, int|string $y1, int|string $x2, int|string $y2): SvgBackendComponent;

    public static function polyline(string $points): SvgBackendComponent;

    public static function polygon(string $points): SvgBackendComponent;

    public static function path(string|Stringable $d): SvgBackendComponent;
}
