<?php

declare(strict_types=1);

namespace Juaniquillo\SvgBackendComponents\Concerns;

trait HasSvgAttributes
{
    abstract public function setAttribute(string $name, int|string|null $content): static;

    public function setViewBox(int|string $minX, int|string $minY, int|string $width, int|string $height): static
    {
        return $this->setAttribute('viewBox', "{$minX} {$minY} {$width} {$height}");
    }

    public function setSize(int|string $width, int|string|null $height = null): static
    {
        return $this
            ->setAttribute('width', $width)
            ->setAttribute('height', $height ?? $width);
    }
}
