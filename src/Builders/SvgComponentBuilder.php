<?php

declare(strict_types=1);

namespace Juaniquillo\SvgBackendComponents\Builders;

use BackedEnum;
use Juaniquillo\BackendComponents\Contracts\StaticBuilder;
use Juaniquillo\SvgBackendComponents\SvgBackendComponent;
use Override;

class SvgComponentBuilder implements StaticBuilder
{
    #[Override]
    public static function make(string|BackedEnum $name): SvgBackendComponent
    {
        return new SvgBackendComponent($name);
    }
}
