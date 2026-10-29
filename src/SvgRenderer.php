<?php

declare(strict_types=1);

namespace Juaniquillo\SvgBackendComponents;

use Illuminate\Contracts\Support\Htmlable;
use RuntimeException;

final readonly class SvgRenderer
{
    private function __construct(private Htmlable $component) {}

    public static function make(Htmlable $component): self
    {
        return new self($component);
    }

    public function toSvg(): string
    {
        return rtrim($this->component->toHtml())."\n";
    }

    public function saveTo(string $path): string
    {
        $directory = dirname($path);

        if (! is_dir($directory) && ! mkdir($directory, recursive: true)) {
            throw new RuntimeException("Unable to create directory [{$directory}].");
        }

        if (file_put_contents($path, $this->toSvg()) === false) {
            throw new RuntimeException("Unable to write SVG to [{$path}].");
        }

        return $path;
    }
}
