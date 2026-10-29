<?php

declare(strict_types=1);

namespace Juaniquillo\SvgBackendComponents\Builders;

use BackedEnum;
use Illuminate\Contracts\Support\Htmlable;
use Juaniquillo\BackendComponents\Contracts\CompoundComponent;
use Juaniquillo\BackendComponents\Contracts\StaticBuilder;
use Juaniquillo\SvgBackendComponents\SvgBackendComponent;

class SvgComponentBuilder implements StaticBuilder
{
    public static function make(string|BackedEnum $name): Htmlable|CompoundComponent
    {
        return new SvgBackendComponent($name);
    }
}
