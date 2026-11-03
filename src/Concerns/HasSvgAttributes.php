<?php

declare(strict_types=1);

namespace Juaniquillo\SvgBackendComponents\Concerns;

trait HasSvgAttributes
{
    abstract public function setAttribute(string $name, int|string|null $content): static;

    public function setXmlns(string $uri = 'http://www.w3.org/2000/svg'): static
    {
        return $this->setAttribute('xmlns', $uri);
    }

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

    public function setFill(?string $color): static
    {
        return $this->setAttribute('fill', $color);
    }

    public function setStroke(?string $color): static
    {
        return $this->setAttribute('stroke', $color);
    }

    public function setStrokeWidth(int|string $width): static
    {
        return $this->setAttribute('stroke-width', $width);
    }

    public function setOpacity(int|string|float $opacity): static
    {
        return $this->setAttribute('opacity', (string) $opacity);
    }
}
