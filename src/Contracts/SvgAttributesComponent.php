<?php

declare(strict_types=1);

namespace Juaniquillo\SvgBackendComponents\Contracts;

interface SvgAttributesComponent
{
    public function setXmlns(string $uri = 'http://www.w3.org/2000/svg'): static;

    public function setViewBox(int|string $minX, int|string $minY, int|string $width, int|string $height): static;

    public function setSize(int|string $width, int|string|null $height = null): static;

    public function setFill(?string $color): static;

    public function setStroke(?string $color): static;

    public function setStrokeWidth(int|string $width): static;

    public function setOpacity(int|string|float $opacity): static;
}
