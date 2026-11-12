# Svg Backend Components

[![CI](https://github.com/juaniquillo/svg-backend-components/actions/workflows/ci.yml/badge.svg)](https://github.com/juaniquillo/svg-backend-components/actions/workflows/ci.yml)

Build SVG graphics from PHP. This package lets you compose SVG elements in backend code with content, attributes, settings, and Tailwind themes, and render them anywhere Blade renders.

## Requirements

- PHP `^8.3`

- Laravel `^12.0|^13.0`

## Installation

You can install the package via Composer:

```bash
composer require juaniquillo/svg-backend-components
```

The package's service provider is discovered automatically by Laravel. Its Blade views are registered under the `svg::` namespace, no Tailwind configuration is needed unless you use themes.

## Built on Base + Laravel Backend Components

This package is an SVG-flavored adapter over [juaniquillo/laravel-backend-component](https://github.com/juaniquillo/laravel-backend-component) ([Packagist](https://packagist.org/packages/juaniquillo/laravel-backend-component)) `^0.12.0`, which in turn is built on [juaniquillo/base-backend-component](https://github.com/juaniquillo/base-backend-component). State (attributes, contents, settings, themes, paths, serialization) lives in the base package; Blade rendering lives in the Laravel package. Both are installed automatically as dependencies, no separate setup needed.

What this package adds on top:

- `SvgBackendComponent`: the component class, hardcoded to the `svg::` view context
- `SvgComponentEnum`: SVG elements as typed cases (`SVG`, `G`, `PATH`, `CIRCLE`, …)
- `SvgComponentFactory` / `SvgLocalThemeComponentFactory`: fluent factories, including app-local theme resolution
- `SvgShape` / `SvgPath`: shape presets for common geometry and a helper for path `d` data
- `SvgRenderer`: standalone SVG document strings and file output via `toSvg()` / `saveTo()`

For the full mechanics (theming file format, serialization, the Blade rendering pipeline, helpers) see the [Laravel Backend Components documentation](https://github.com/juaniquillo/backend-component-docs).

> [!TIP]
> #### Laravel Boost Skill
> If you use [Laravel Boost](https://github.com/laravel/boost), install the AI skill:
> ```bash
> php artisan boost:add-skill https://github.com/juaniquillo/svg-backend-components
> ```

## Usage

Element attributes (`viewBox`, `d`, `fill`, …) are passed with `setAttribute()` / `setAttributes()`.

### Components

Pick an element from the enum, set content and attributes, and render it. Components implement Laravel's `Htmlable` contract, so Blade renders them unescaped:

```php
use Juaniquillo\SvgBackendComponents\SvgBackendComponent;
use Juaniquillo\SvgBackendComponents\SvgComponentEnum;

$icon = (new SvgBackendComponent(SvgComponentEnum::SVG))
    ->setAttributes(['viewBox' => '0 0 24 24', 'fill' => 'none'])
    ->setContents([
        (new SvgBackendComponent(SvgComponentEnum::PATH))
            ->setAttribute('d', 'M0 0h24v24H0z'),
    ]);
```

```blade
{{ $icon }}
```

Or render to a string anywhere:

```php
$html = $icon->toHtml();
```

### Factories

Fluent factories are available when you prefer them over `new`:

```php
use Juaniquillo\SvgBackendComponents\Factories\SvgComponentFactory;
use Juaniquillo\SvgBackendComponents\Factories\SvgLocalThemeComponentFactory;
use Juaniquillo\SvgBackendComponents\SvgComponentEnum;

$icon = SvgComponentFactory::make(SvgComponentEnum::SVG)
    ->setXmlns()
    ->setViewBox(0, 0, 24, 24)
    ->setSize(24)
    ->setContents([
        (new SvgBackendComponent(SvgComponentEnum::PATH))->setAttribute('d', 'M0 0h24v24H0z'),
    ]);

// Aliases for common presentation attributes:
$rect = SvgComponentFactory::make(SvgComponentEnum::RECT)
    ->setFill('#3b82f6')
    ->setStroke('#111827')
    ->setStrokeWidth(2)
    ->setOpacity(0.5);

// Shape presets for common geometry (same component back, fully chainable):
use Juaniquillo\SvgBackendComponents\Shapes\SvgShape;

$rect = SvgShape::rect(10, 10, 80, 50)->setFill('#3b82f6');
$circle = SvgShape::circle(140, 35, 25)->setFill('#ef4444');

// Path data helper for the `d` attribute (prefer the command methods; raw() for anything else):
use Juaniquillo\SvgBackendComponents\Shapes\SvgPath;

$path = SvgShape::path(
    SvgPath::start(10, 100)->lineTo(60, 40)->close()
)->setFill('none');

// Resolves themes from your app's views instead of the package defaults.
// Group names are app-defined; this app paints SVG through its `fill` group.
$themed = SvgLocalThemeComponentFactory::make(SvgComponentEnum::PATH)
    ->setTheme('fill', 'muted');
```

### Themes

Apply Tailwind theme variants with `setTheme()` / `setThemes()`:

```php
$path = SvgComponentFactory::make(SvgComponentEnum::PATH)
    ->setTheme('fill', 'muted');
```

Theme files live in your app's `resources/views/_themes/tailwind/` directory (one Blade file per theme group returning a variant array), resolved through the local theme factories. See [theming in the engine docs](https://github.com/juaniquillo/backend-component-docs/blob/main/05-theming.md) for the file format.

## Examples

The `examples/` directory holds one runnable script per use-case (basic shapes, paths, path data helper, reuse with `defs`/`use`, gradients, clipping, text, images, theming). Each file returns a complete `<svg>` document; render them all with:

```bash
composer examples
```

Outputs are written to `examples/output/*.svg` (gitignored) so you can open them directly in a browser.

Need the markup as a string or written to disk from your own code? Use the renderer:

```php
use Juaniquillo\SvgBackendComponents\SvgRenderer;

$svg = SvgRenderer::make($icon)->toSvg(); // full SVG document string

SvgRenderer::make($icon)->saveTo(storage_path('app/icon.svg')); // writes the file, returns its path
```

## Testing

Individual checks:

- `composer analyse`: PHPStan static analysis over `src/`.
- `composer rector:check`: Rector dry-run over `src/` (use `composer rector` to apply fixes).
- `composer lint:check`: Pint style check over `src/` (use `composer lint` to fix).
- `composer test:types`: enforces 100% type coverage.
- `composer test:unit`: the Pest suite (parallel everywhere except Windows, where it runs serially to avoid file-lock collisions).

Or run the whole gate at once, the same scripts CI executes, in order:

```bash
composer qa
```

## License

Svg Backend Components is open-sourced software licensed under the [MIT license](LICENSE.md).
