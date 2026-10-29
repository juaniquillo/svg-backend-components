<?php

declare(strict_types=1);

namespace Juaniquillo\SvgBackendComponents\Contracts;

interface SvgAttributesComponent
{
    public function setViewBox(int|string $minX, int|string $minY, int|string $width, int|string $height): static;

    public function setSize(int|string $width, int|string|null $height = null): static;
}
