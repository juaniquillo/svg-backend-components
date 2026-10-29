<?php

declare(strict_types=1);

namespace Juaniquillo\SvgBackendComponents\Builders;

use BackedEnum;
use Juaniquillo\BackendComponents\Contracts\StaticBuilder;
use Juaniquillo\BackendComponents\Themes\LocalThemeManager;
use Juaniquillo\SvgBackendComponents\SvgBackendComponent;
use Override;

class SvgLocalThemeComponentBuilder implements StaticBuilder
{
    #[Override]
    public static function make(string|BackedEnum $name): SvgBackendComponent
    {
        return new SvgBackendComponent($name, new LocalThemeManager);
    }
}
