<?php

/**
 * @package Referential
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Referential\Reference;

use DecodeLabs\Referential\Reference;
use DecodeLabs\Referential\ReferenceTrait;
use DecodeLabs\Tagged\Element;
use DecodeLabs\Tagged\Markup;

class NumericId implements Reference
{
    use ReferenceTrait;

    public const string CanonicalPattern = '/^([0-9]+)$/';
    public const int CanonicalMaxLength = 32;
    public const string NormalPattern = self::CanonicalPattern;
    public const int NormalMaxLength = self::CanonicalMaxLength;
    public const string Example = '123456';

    /**
     * @param array<string> $matches
     */
    protected function formatHtmlMatches(
        array $matches
    ): Markup {
        return Element::create('samp.number.numeric-id', function () use ($matches) {
            yield Element::create('span.value', $matches[0]);
        }, [
            'title' => $this->canonical
        ]);
    }

    public static function isGeneric(): bool
    {
        return true;
    }
}
