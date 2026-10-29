<?php

declare(strict_types=1);

namespace Juaniquillo\SvgBackendComponents;

use BackedEnum;
use Illuminate\Contracts\Support\Htmlable;
use Juaniquillo\BackendComponents\Components\DefaultAttributeBag;
use Juaniquillo\BackendComponents\Concerns\HasContent;
use Juaniquillo\BackendComponents\Concerns\HasPath;
use Juaniquillo\BackendComponents\Concerns\HasSettings;
use Juaniquillo\BackendComponents\Concerns\IsBackendComponent;
use Juaniquillo\BackendComponents\Concerns\IsThemeable;
use Juaniquillo\BackendComponents\Contracts\AttributeBag;
use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Contracts\ContentComponent;
use Juaniquillo\BackendComponents\Contracts\PathComponent;
use Juaniquillo\BackendComponents\Contracts\SettingsComponent;
use Juaniquillo\BackendComponents\Contracts\StaticBuilder;
use Juaniquillo\BackendComponents\Contracts\ThemeComponent;
use Juaniquillo\BackendComponents\Contracts\ThemeManager;
use Juaniquillo\BackendComponents\Themes\DefaultThemeManager;
use Juaniquillo\SvgBackendComponents\Concerns\HasSvgAttributes;
use Juaniquillo\SvgBackendComponents\Contracts\SvgAttributesComponent;
use Override;

use function Juaniquillo\BackendComponents\isBackedEnum;

final class SvgBackendComponent implements BackendComponent, ContentComponent, Htmlable, PathComponent, SettingsComponent, StaticBuilder, SvgAttributesComponent, ThemeComponent
{
    use HasContent;
    use HasPath;
    use HasSettings;
    use HasSvgAttributes;
    use IsBackendComponent;
    use IsThemeable;

    private const string UTILITY_VIEW = 'svg::_utilities.resolve-component';

    public function __construct(
        private string|BackedEnum $name,
        ThemeManager $themeManager = new DefaultThemeManager,
    ) {
        $this->themeManager = $themeManager;
    }

    #[Override]
    public static function make(string|BackedEnum $name): static
    {
        return new self($name);
    }

    /**
     * Hardcode context
     */
    public function getContext(): string
    {
        return 'svg::';
    }

    public function getName(): int|string
    {
        $name = $this->name;

        if (isBackedEnum($name)) {
            return $name->value;
        }

        return $name;
    }

    public function getAttributeBag(): AttributeBag
    {
        return new DefaultAttributeBag(
            $this->getAttributes(),
            $this->processContent(),
            $this->compileTheme(),
            $this->getComponentPath(),
            $this->getSettings(),
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'attributes' => $this->getAttributes(),
            'content' => $this->processContent()->toArray(),
            'path' => $this->getComponentPath(),
            'settings' => $this->getSettings(),
            'theme' => [
                'manager' => $this->themeManager::class,
                'themes' => $this->getThemes(),
                'path' => $this->themeManager->getDefaultPath(),
                'realPath' => $this->themeManager->getThemePath(),
            ],
        ];
    }

    public function toHtml(): string
    {
        return \view(self::UTILITY_VIEW)
            ->with('component', $this)
            ->render();
    }
}
