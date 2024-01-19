<?php

/**
 * @package Referential
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Referential\Reference;

use DecodeLabs\Referential\Reference;
use DecodeLabs\Referential\ReferenceTrait;
use DecodeLabs\Tagged as Html;
use DecodeLabs\Tagged\Markup;

class InitialKey implements Reference
{
    use ReferenceTrait;

    public const CANONICAL_PATTERN = '/^([A-Z])([A-Z0-9]{2,})$/';
    public const CANONICAL_MAX_LENGTH = 12;
    public const NORMAL_PATTERN = self::CANONICAL_PATTERN;
    public const NORMAL_MAX_LENGTH = self::CANONICAL_MAX_LENGTH;
    public const EXAMPLE = 'MTR1';

    /**
     * Convert canonical to html value
     *
     * @param array<string> $matches
     */
    protected function formatHtmlMatches(
        array $matches
    ): Markup {
        return Html::{'samp.number.initial'}(function () use ($matches) {
            yield Html::{'span.value'}($matches[0] . $matches[1]);
        }, [
            'title' => $this->canonical
        ]);
    }
}
