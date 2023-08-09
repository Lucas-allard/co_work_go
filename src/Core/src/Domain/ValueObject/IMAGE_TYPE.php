<?php

namespace Core\Domain\ValueObject;

use MyCLabs\Enum\Enum;

/**
 * Action enum
 *
 * @extends Enum<Action::*>
 */
final class IMAGE_TYPE extends Enum
{
    private const JPG = 'jpg';
    private const PNG = 'png';
    private const GIF = 'gif';
    private const WEBP = 'webp';
    private const SVG = 'svg';
    private const ICO = 'ico';
}

