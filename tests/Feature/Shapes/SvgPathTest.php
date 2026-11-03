<?php

declare(strict_types=1);

use Juaniquillo\SvgBackendComponents\Shapes\SvgPath;
use Juaniquillo\SvgBackendComponents\Shapes\SvgShape;

it('starts a path with an absolute moveto', function () {
    expect(SvgPath::start(10, 10)->toString())->toBe('M 10 10');
});

it('chains absolute commands', function () {
    $d = SvgPath::start(10, 10)
        ->lineTo(50, 50)
        ->horizontalLineTo(90)
        ->verticalLineTo(20)
        ->close()
        ->toString();

    expect($d)->toBe('M 10 10 L 50 50 H 90 V 20 Z');
});

it('supports relative commands', function () {
    $d = SvgPath::start(10, 10)
        ->lineToRelative(40, 40)
        ->horizontalLineToRelative(40)
        ->verticalLineToRelative(-30)
        ->moveToRelative(5, 5)
        ->toString();

    expect($d)->toBe('M 10 10 l 40 40 h 40 v -30 m 5 5');
});

it('appends raw fragments as an escape hatch', function () {
    $d = SvgPath::start(120, 30)
        ->raw('C 140 10, 170 10, 185 30')
        ->toString();

    expect($d)->toBe('M 120 30 C 140 10, 170 10, 185 30');
});

it('casts to string', function () {
    expect((string) SvgPath::start(10, 10)->close())->toBe('M 10 10 Z');
});

it('feeds straight into the shape factory', function () {
    $path = SvgShape::path(
        SvgPath::start(10, 10)->lineTo(50, 50)->close()
    )->setFill('none');

    expect($path->getAttributes())->toBe(['d' => 'M 10 10 L 50 50 Z', 'fill' => 'none']);
});
