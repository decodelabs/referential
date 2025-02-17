<?php

/**
 * @package Referential
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Referential\Reference\Commerce;

use DecodeLabs\Referential\Reference;
use DecodeLabs\Referential\ReferenceTrait;
use DecodeLabs\Tagged\Element;
use DecodeLabs\Tagged\Markup;

class Upc implements Reference
{
    use ReferenceTrait;

    public const string CanonicalPattern = '/^([0-9]{12,13})$/';
    public const int CanonicalMaxLength = 13;
    public const string NormalPattern = self::CanonicalPattern;
    public const int NormalMaxLength = self::CanonicalMaxLength;
    public const string Example = '0799439112766';

    /**
     * Convert canonical to html value
     *
     * @param array<string> $matches
     */
    protected function formatHtmlMatches(
        array $matches
    ): Markup {
        return Element::create('samp.number.commerce.upc', function () use ($matches) {
            yield Element::create('span.value', $matches[0]);
        }, [
            'title' => $this->canonical
        ]);
    }
}
