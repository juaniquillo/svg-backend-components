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
