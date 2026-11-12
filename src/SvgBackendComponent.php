<?php

declare(strict_types=1);

namespace Juaniquillo\SvgBackendComponents;

use BackedEnum;
use Illuminate\Contracts\Support\Htmlable;
use Juaniquillo\BackendComponents\Components\DefaultAttributeBag;
use Juaniquillo\BackendComponents\Concerns\HasContent;
use Juaniquillo\BackendComponents\Concerns\HasPath;
use Juaniquillo\BackendComponents\Concerns\IsBackendComponent;
use Juaniquillo\BackendComponents\Contracts\StaticFactory;
use Juaniquillo\BackendComponents\Themes\DefaultThemeManager;
use Juaniquillo\BaseBackendComponent\Concerns\HasSettings;
use Juaniquillo\BaseBackendComponent\Concerns\IsThemeable;
use Juaniquillo\BaseBackendComponent\Contracts\AttributeBag;
use Juaniquillo\BaseBackendComponent\Contracts\BackendComponent;
use Juaniquillo\BaseBackendComponent\Contracts\CompoundComponent;
use Juaniquillo\BaseBackendComponent\Contracts\ThemeManager;
use Juaniquillo\SvgBackendComponents\Concerns\HasSvgAttributes;
use Juaniquillo\SvgBackendComponents\Contracts\SvgAttributesComponent;
use Override;
use ValueError;

use function Juaniquillo\BaseBackendComponent\isBackedEnum;

/**
 * @phpstan-import-type ComponentArray from BackendComponent
 */
final class SvgBackendComponent implements CompoundComponent, Htmlable, StaticFactory, SvgAttributesComponent
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
        if (\is_string($name) && SvgComponentEnum::tryFrom($name) === null) {
            $accepted = [];

            foreach (SvgComponentEnum::cases() as $case) {
                $accepted[] = $case->value;
            }

            throw new ValueError('Invalid SVG element ['.$name.']. Expected one of ['.\implode(', ', $accepted).'] in ['.SvgComponentEnum::class.'].');
        }

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
            attributes: $this->getAttributes(),
            content: $this->processContent(),
            themes: $this->compileTheme(),
            path: $this->getComponentPath(),
            settings: $this->getSettings(),
        );
    }

    /**
     * @return ComponentArray
     */
    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'component' => self::class,
            'attributes' => $this->getAttributes(),
            'contents' => $this->processContent()->toArray(),
            'theme' => [
                'manager' => $this->getThemeManager()::class,
                'themes' => $this->getThemes(),
                'path' => $this->getThemeManager()->getDefaultPath(),
                'realPath' => $this->getThemeManager()->getThemePath(),
            ],
            'path' => $this->getPathOnly(),
            'settings' => $this->getSettings(),
        ];
    }

    public function toHtml(): string
    {
        return \view(self::UTILITY_VIEW)
            ->with('component', $this)
            ->render();
    }
}
