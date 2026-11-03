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

it('builds cubic curves', function () {
    expect(SvgPath::start(120, 30)->curveTo(140, 10, 170, 10, 185, 30)->toString())
        ->toBe('M 120 30 C 140 10, 170 10, 185 30')
        ->and(SvgPath::start(120, 30)->curveToRelative(20, -20, 50, -20, 65, 0)->toString())
        ->toBe('M 120 30 c 20 -20, 50 -20, 65 0');
});

it('builds quadratic curves', function () {
    expect(SvgPath::start(10, 10)->quadraticTo(50, 0, 90, 10)->toString())
        ->toBe('M 10 10 Q 50 0, 90 10')
        ->and(SvgPath::start(10, 10)->quadraticToRelative(40, -10, 80, 0)->toString())
        ->toBe('M 10 10 q 40 -10, 80 0');
});

it('builds smooth curves', function () {
    expect(SvgPath::start(10, 10)->smoothCurveTo(50, 0, 90, 10)->toString())
        ->toBe('M 10 10 S 50 0, 90 10')
        ->and(SvgPath::start(10, 10)->smoothCurveToRelative(40, -10, 80, 0)->toString())
        ->toBe('M 10 10 s 40 -10, 80 0')
        ->and(SvgPath::start(10, 10)->smoothQuadraticTo(90, 10)->toString())
        ->toBe('M 10 10 T 90 10')
        ->and(SvgPath::start(10, 10)->smoothQuadraticToRelative(80, 0)->toString())
        ->toBe('M 10 10 t 80 0');
});

it('builds arcs with boolean flags', function () {
    expect(SvgPath::start(10, 10)->arcTo(30, 30, 0, true, false, 70, 10)->toString())
        ->toBe('M 10 10 A 30 30 0 1 0 70 10')
        ->and(SvgPath::start(10, 10)->arcTo(30, 30, 45, false, true, 70, 10)->toString())
        ->toBe('M 10 10 A 30 30 45 0 1 70 10')
        ->and(SvgPath::start(10, 10)->arcToRelative(30, 30, 0, true, true, 60, 0)->toString())
        ->toBe('M 10 10 a 30 30 0 1 1 60 0');
});

it('mixes every command family in one chain', function () {
    $d = SvgPath::start(10, 100)
        ->lineTo(60, 40)
        ->curveTo(80, 20, 100, 20, 120, 40)
        ->quadraticTo(140, 60, 160, 40)
        ->smoothCurveTo(180, 20, 190, 40)
        ->smoothQuadraticTo(195, 60)
        ->arcTo(10, 10, 0, false, true, 190, 80)
        ->horizontalLineTo(150)
        ->verticalLineTo(100)
        ->close()
        ->toString();

    expect($d)->toBe('M 10 100 L 60 40 C 80 20, 100 20, 120 40 Q 140 60, 160 40 S 180 20, 190 40 T 195 60 A 10 10 0 0 1 190 80 H 150 V 100 Z');
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
