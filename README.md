# Svg Backend Components

Build SVG graphics from PHP. This package lets you compose SVG elements in backend code with content, attributes, settings, and Tailwind themes, and render them anywhere Blade renders.

## Requirements

- PHP `^8.3`

- Laravel `^12.0|^13.0`

## Installation

You can install the package via Composer:

```
composer require juaniquillo/svg-backend-components
```

The package's service provider is discovered automatically by Laravel. Its Blade views are registered under the `svg::` namespace, no Tailwind configuration is needed unless you use themes.

## Built on Laravel Backend Components

This package is an SVG-flavored adapter over [juaniquillo/laravel-backend-component](https://github.com/juaniquillo/laravel-backend-component) ([Packagist](https://packagist.org/packages/juaniquillo/laravel-backend-component)), which provides the underlying engine: the component model, theme managers, and the Blade rendering pipeline. It is installed automatically as a dependency, no separate setup needed.

What this package adds on top:

- `SvgBackendComponent`: the component class, hardcoded to the `svg::` view context
- `SvgComponentEnum`: SVG elements as typed cases (`SVG`, `G`, `PATH`, `CIRCLE`, …)
- `SvgComponentBuilder` / `SvgLocalThemeComponentBuilder`: fluent factories, including app-local theme resolution

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

```
use Juaniquillo\SvgBackendComponents\SvgBackendComponent;
use Juaniquillo\SvgBackendComponents\SvgComponentEnum;

$icon = (new SvgBackendComponent(SvgComponentEnum::SVG))
    ->setAttributes(['viewBox' => '0 0 24 24', 'fill' => 'none'])
    ->setContents([
        (new SvgBackendComponent(SvgComponentEnum::PATH))
            ->setAttribute('d', 'M0 0h24v24H0z'),
    ]);
```

```
{{ $icon }}
```

Or render to a string anywhere:

```
$html = $icon->toHtml();
```

### Builders

Fluent factories are available when you prefer them over `new`. The `svg()` shorthand builds a root element with the `xmlns` attribute already set:

```
use Juaniquillo\SvgBackendComponents\Builders\SvgComponentBuilder;
use Juaniquillo\SvgBackendComponents\Builders\SvgLocalThemeComponentBuilder;
use Juaniquillo\SvgBackendComponents\SvgComponentEnum;

$icon = SvgComponentBuilder::svg(
    [(new SvgBackendComponent(SvgComponentEnum::PATH))->setAttribute('d', 'M0 0h24v24H0z')],
    ['viewBox' => '0 0 24 24'],
);

// Or build the root by hand and set the viewport with helpers:
$icon = SvgComponentBuilder::make(SvgComponentEnum::SVG)
    ->setViewBox(0, 0, 24, 24)
    ->setSize(24);

// Resolves themes from your app's views instead of the package defaults.
$themed = SvgLocalThemeComponentBuilder::make(SvgComponentEnum::PATH)
    ->setTheme('color', 'success');
```

### Themes

Apply Tailwind theme variants with `setTheme()` / `setThemes()`:

```
$path = SvgComponentBuilder::make(SvgComponentEnum::PATH)
    ->setTheme('color', 'success');
```

Theme files live in your app's `resources/views/_themes/tailwind/` directory (one Blade file per theme group returning a variant array), resolved through the local theme builders.

## Examples

The `examples/` directory holds one runnable script per use-case (basic shapes, paths, reuse with `defs`/`use`, gradients, clipping, text, images, theming). Each file returns a complete `<svg>` document; render them all with:

```
composer examples
```

Outputs are written to `examples/output/*.svg` (gitignored) so you can open them directly in a browser.

Need the markup as a string or written to disk from your own code? Use the renderer:

```
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

```
composer qa
```

## License

Svg Backend Components is open-sourced software licensed under the [MIT license](LICENSE.md).
