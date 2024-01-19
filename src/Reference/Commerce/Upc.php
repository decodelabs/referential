<?php

/**
 * @package Referential
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Referential\Reference\Commerce;

use DecodeLabs\Referential\Reference;
use DecodeLabs\Referential\ReferenceTrait;
use DecodeLabs\Tagged as Html;
use DecodeLabs\Tagged\Markup;

class Upc implements Reference
{
    use ReferenceTrait;

    public const CANONICAL_PATTERN = '/^([0-9]{12,13})$/';
    public const CANONICAL_MAX_LENGTH = 13;
    public const NORMAL_PATTERN = self::CANONICAL_PATTERN;
    public const NORMAL_MAX_LENGTH = self::CANONICAL_MAX_LENGTH;
    public const EXAMPLE = '0799439112766';

    /**
     * Convert canonical to html value
     *
     * @param array<string> $matches
     */
    protected function formatHtmlMatches(
        array $matches
    ): Markup {
        return Html::{'samp.number.commerce.upc'}(function () use ($matches) {
            yield Html::{'span.value'}($matches[0]);
        }, [
            'title' => $this->canonical
        ]);
    }
}
