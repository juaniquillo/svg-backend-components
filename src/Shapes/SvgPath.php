<?php

declare(strict_types=1);

namespace Juaniquillo\SvgBackendComponents\Shapes;

use Stringable;

final class SvgPath implements Stringable
{
    /** @var list<string> */
    private array $commands = [];

    private function __construct() {}

    public static function start(int|string $x, int|string $y): self
    {
        return (new self)->moveTo($x, $y);
    }

    public function moveTo(int|string $x, int|string $y): static
    {
        $this->commands[] = "M {$x} {$y}";

        return $this;
    }

    public function moveToRelative(int|string $dx, int|string $dy): static
    {
        $this->commands[] = "m {$dx} {$dy}";

        return $this;
    }

    public function lineTo(int|string $x, int|string $y): static
    {
        $this->commands[] = "L {$x} {$y}";

        return $this;
    }

    public function lineToRelative(int|string $dx, int|string $dy): static
    {
        $this->commands[] = "l {$dx} {$dy}";

        return $this;
    }

    public function horizontalLineTo(int|string $x): static
    {
        $this->commands[] = "H {$x}";

        return $this;
    }

    public function horizontalLineToRelative(int|string $dx): static
    {
        $this->commands[] = "h {$dx}";

        return $this;
    }

    public function verticalLineTo(int|string $y): static
    {
        $this->commands[] = "V {$y}";

        return $this;
    }

    public function verticalLineToRelative(int|string $dy): static
    {
        $this->commands[] = "v {$dy}";

        return $this;
    }

    public function curveTo(int|string $x1, int|string $y1, int|string $x2, int|string $y2, int|string $x, int|string $y): static
    {
        $this->commands[] = "C {$x1} {$y1}, {$x2} {$y2}, {$x} {$y}";

        return $this;
    }

    public function curveToRelative(int|string $dx1, int|string $dy1, int|string $dx2, int|string $dy2, int|string $dx, int|string $dy): static
    {
        $this->commands[] = "c {$dx1} {$dy1}, {$dx2} {$dy2}, {$dx} {$dy}";

        return $this;
    }

    public function quadraticTo(int|string $x1, int|string $y1, int|string $x, int|string $y): static
    {
        $this->commands[] = "Q {$x1} {$y1}, {$x} {$y}";

        return $this;
    }

    public function quadraticToRelative(int|string $dx1, int|string $dy1, int|string $dx, int|string $dy): static
    {
        $this->commands[] = "q {$dx1} {$dy1}, {$dx} {$dy}";

        return $this;
    }

    public function smoothCurveTo(int|string $x2, int|string $y2, int|string $x, int|string $y): static
    {
        $this->commands[] = "S {$x2} {$y2}, {$x} {$y}";

        return $this;
    }

    public function smoothCurveToRelative(int|string $dx2, int|string $dy2, int|string $dx, int|string $dy): static
    {
        $this->commands[] = "s {$dx2} {$dy2}, {$dx} {$dy}";

        return $this;
    }

    public function smoothQuadraticTo(int|string $x, int|string $y): static
    {
        $this->commands[] = "T {$x} {$y}";

        return $this;
    }

    public function smoothQuadraticToRelative(int|string $dx, int|string $dy): static
    {
        $this->commands[] = "t {$dx} {$dy}";

        return $this;
    }

    public function arcTo(int|string $rx, int|string $ry, int|string $rotation, bool $largeArc, bool $sweep, int|string $x, int|string $y): static
    {
        $large = $largeArc ? '1' : '0';
        $sweepFlag = $sweep ? '1' : '0';

        $this->commands[] = "A {$rx} {$ry} {$rotation} {$large} {$sweepFlag} {$x} {$y}";

        return $this;
    }

    public function arcToRelative(int|string $rx, int|string $ry, int|string $rotation, bool $largeArc, bool $sweep, int|string $dx, int|string $dy): static
    {
        $large = $largeArc ? '1' : '0';
        $sweepFlag = $sweep ? '1' : '0';

        $this->commands[] = "a {$rx} {$ry} {$rotation} {$large} {$sweepFlag} {$dx} {$dy}";

        return $this;
    }

    public function close(): static
    {
        $this->commands[] = 'Z';

        return $this;
    }

    public function raw(string $fragment): static
    {
        $this->commands[] = $fragment;

        return $this;
    }

    public function toString(): string
    {
        return implode(' ', $this->commands);
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
