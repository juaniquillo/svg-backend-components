<?php

declare(strict_types=1);

namespace Juaniquillo\SvgBackendComponents\Builders;

use BackedEnum;
use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Contracts\CompoundComponent;
use Juaniquillo\BackendComponents\Contracts\StaticBuilder;
use Juaniquillo\SvgBackendComponents\SvgBackendComponent;
use Juaniquillo\SvgBackendComponents\SvgComponentEnum;
use Override;

class SvgComponentBuilder implements StaticBuilder
{
    #[Override]
    public static function make(string|BackedEnum $name): SvgBackendComponent
    {
        return new SvgBackendComponent($name);
    }

    /**
     * @param  array<string|int, string|int|CompoundComponent|BackendComponent>  $contents
     * @param  array<string, int|string|null>  $attributes
     */
    public static function svg(array $contents = [], array $attributes = []): SvgBackendComponent
    {
        return static::make(SvgComponentEnum::SVG)
            ->setAttributes(array_merge(['xmlns' => 'http://www.w3.org/2000/svg'], $attributes))
            ->setContents($contents);
    }
}
