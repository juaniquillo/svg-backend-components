<?php

declare(strict_types=1);

namespace Juaniquillo\SvgBackendComponents\Factories;

use BackedEnum;
use Juaniquillo\BackendComponents\Contracts\StaticFactory;
use Juaniquillo\BackendComponents\Themes\LocalThemeManager;
use Juaniquillo\SvgBackendComponents\SvgBackendComponent;
use Override;

class SvgLocalThemeComponentFactory implements StaticFactory
{
    #[Override]
    public static function make(string|BackedEnum $name): SvgBackendComponent
    {
        return new SvgBackendComponent($name, new LocalThemeManager);
    }
}
