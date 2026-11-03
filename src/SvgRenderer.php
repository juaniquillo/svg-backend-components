<?php

declare(strict_types=1);

namespace Juaniquillo\SvgBackendComponents;

use Illuminate\Contracts\Support\Htmlable;
use RuntimeException;

final readonly class SvgRenderer
{
    private const string PROLOG = '<?xml version="1.0" encoding="UTF-8"?>';

    private function __construct(private Htmlable $component) {}

    public static function make(Htmlable $component): self
    {
        return new self($component);
    }

    public function toSvg(bool $prolog = false): string
    {
        return $this->render($this->component, $prolog);
    }

    public function saveTo(string $path, bool $prolog = false): string
    {
        $directory = dirname($path);

        if (! is_dir($directory)) {
            if (file_exists($directory) || ! mkdir($directory, recursive: true)) {
                throw new RuntimeException("Unable to create directory [{$directory}].");
            }
        }

        $component = $this->component;

        if ($component instanceof SvgBackendComponent && $component->getName() === 'svg' && $component->getAttribute('xmlns') === null) {
            $component = (clone $component)->setXmlns();
        }

        if (file_put_contents($path, $this->render($component, $prolog)) === false) {
            throw new RuntimeException("Unable to write SVG to [{$path}].");
        }

        return $path;
    }

    private function render(Htmlable $component, bool $prolog): string
    {
        $svg = rtrim($component->toHtml())."\n";

        return $prolog ? self::PROLOG."\n".$svg : $svg;
    }
}
