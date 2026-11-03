<?php

declare(strict_types=1);

use Juaniquillo\SvgBackendComponents\Shapes\SvgShape;
use Juaniquillo\SvgBackendComponents\SvgBackendComponent;

it('builds a rect', function () {
    $component = SvgShape::rect(10, 10, 80, 50);

    expect($component)->toBeInstanceOf(SvgBackendComponent::class)
        ->and($component->getName())->toBe('rect')
        ->and($component->getAttributes())->toBe(['x' => 10, 'y' => 10, 'width' => 80, 'height' => 50]);
});

it('builds a circle', function () {
    $component = SvgShape::circle(140, 35, 25);

    expect($component->getName())->toBe('circle')
        ->and($component->getAttributes())->toBe(['cx' => 140, 'cy' => 35, 'r' => 25]);
});

it('builds an ellipse', function () {
    $component = SvgShape::ellipse(50, 90, 35, 18);

    expect($component->getName())->toBe('ellipse')
        ->and($component->getAttributes())->toBe(['cx' => 50, 'cy' => 90, 'rx' => 35, 'ry' => 18]);
});

it('builds a line', function () {
    $component = SvgShape::line(110, 80, 180, 100);

    expect($component->getName())->toBe('line')
        ->and($component->getAttributes())->toBe(['x1' => 110, 'y1' => 80, 'x2' => 180, 'y2' => 100]);
});

it('builds a polyline', function () {
    $component = SvgShape::polyline('10,110 40,60 70,90 100,40');

    expect($component->getName())->toBe('polyline')
        ->and($component->getAttributes())->toBe(['points' => '10,110 40,60 70,90 100,40']);
});

it('builds a polygon', function () {
    $component = SvgShape::polygon('130,100 150,60 170,100');

    expect($component->getName())->toBe('polygon')
        ->and($component->getAttributes())->toBe(['points' => '130,100 150,60 170,100']);
});

it('builds a path', function () {
    $component = SvgShape::path('M120 30 C 140 10, 170 10, 185 30');

    expect($component->getName())->toBe('path')
        ->and($component->getAttributes())->toBe(['d' => 'M120 30 C 140 10, 170 10, 185 30']);
});

it('chains presentation aliases after the factory', function () {
    $component = SvgShape::rect(10, 10, 80, 50)
        ->setFill('#3b82f6')
        ->setStroke('#111827')
        ->setStrokeWidth(2);

    expect($component->getAttributes())->toBe([
        'x' => 10,
        'y' => 10,
        'width' => 80,
        'height' => 50,
        'fill' => '#3b82f6',
        'stroke' => '#111827',
        'stroke-width' => 2,
    ]);
});
