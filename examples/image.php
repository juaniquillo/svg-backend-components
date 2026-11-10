<?php

declare(strict_types=1);

use Juaniquillo\SvgBackendComponents\Factories\SvgComponentFactory;
use Juaniquillo\SvgBackendComponents\SvgComponentEnum;

$image = base64_encode((string) file_get_contents(__DIR__.'/assets/sample.jpg'));

return SvgComponentFactory::make(SvgComponentEnum::SVG)
    ->setXmlns()
    ->setViewBox(0, 0, 200, 100)
    ->setSize(200, 100)
    ->setContents([
        SvgComponentFactory::make(SvgComponentEnum::IMAGE)
            ->setAttributes(['href' => 'data:image/jpeg;base64,'.$image, 'x' => '0', 'y' => '0', 'width' => '200', 'height' => '100']),
    ]);
