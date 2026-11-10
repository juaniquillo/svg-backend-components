<?php

declare(strict_types=1);

namespace Juaniquillo\SvgBackendComponents\Factories;

use BackedEnum;
use Juaniquillo\BackendComponents\Contracts\StaticFactory;
use Juaniquillo\SvgBackendComponents\SvgBackendComponent;
use Override;

class SvgComponentFactory implements StaticFactory
{
    #[Override]
    public static function make(string|BackedEnum $name): SvgBackendComponent
    {
        return new SvgBackendComponent($name);
    }
}
