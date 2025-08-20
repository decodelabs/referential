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

class InitialKey implements Reference
{
    use ReferenceTrait;

    public const string CanonicalPattern = '/^([A-Z])([A-Z0-9]{2,})$/';
    public const int CanonicalMaxLength = 12;
    public const string NormalPattern = self::CanonicalPattern;
    public const int NormalMaxLength = self::CanonicalMaxLength;
    public const string Example = 'MTR1';

    /**
     * @param array<string> $matches
     */
    protected function formatHtmlMatches(
        array $matches
    ): Markup {
        return Element::create('samp.number.initial', function () use ($matches) {
            yield Element::create('span.value', $matches[0] . $matches[1]);
        }, [
            'title' => $this->canonical
        ]);
    }
}
