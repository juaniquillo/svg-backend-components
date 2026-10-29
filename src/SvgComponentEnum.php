<?php

declare(strict_types=1);

namespace Juaniquillo\SvgBackendComponents;

enum SvgComponentEnum: string
{
    case SVG = 'svg';
    case G = 'g';
    case DEFS = 'defs';
    case SYMBOL = 'symbol';
    case USE = 'use';
    case TITLE = 'title';
    case DESC = 'desc';
    case RECT = 'rect';
    case CIRCLE = 'circle';
    case ELLIPSE = 'ellipse';
    case LINE = 'line';
    case POLYLINE = 'polyline';
    case POLYGON = 'polygon';
    case PATH = 'path';
    case TEXT = 'text';
    case TSPAN = 'tspan';
    case IMAGE = 'image';
}
