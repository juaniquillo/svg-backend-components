<?php

declare(strict_types=1);

use Juaniquillo\SvgBackendComponents\Builders\SvgComponentBuilder;
use Juaniquillo\SvgBackendComponents\SvgComponentEnum;

$image = base64_encode((string) file_get_contents(__DIR__.'/assets/sample.jpg'));

return SvgComponentBuilder::svg(
    [
        SvgComponentBuilder::make(SvgComponentEnum::IMAGE)
            ->setAttributes(['href' => 'data:image/jpeg;base64,'.$image, 'x' => '0', 'y' => '0', 'width' => '200', 'height' => '100']),
    ],
    [
        'viewBox' => '0 0 200 100',
        'width' => '200',
        'height' => '100',
    ],
);
