<?php

/**
 * @package Referential
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Referential\Reference\Banking;

use DecodeLabs\Referential\Reference;
use DecodeLabs\Referential\ReferenceTrait;
use DecodeLabs\Tagged\Element;
use DecodeLabs\Tagged\Markup;

class RoutingNumber implements Reference
{
    use ReferenceTrait;

    public const string CanonicalPattern = '/^([0-9]{4})([0-9]{4})([0-9]{1})$/';
    public const int CanonicalMaxLength = 9;
    public const string NormalPattern = '/^([0-9]{4}) ?([0-9]{4}) ?([0-9]{1})$/';
    public const int NormalMaxLength = 11;
    public const string Example = '061000104';


    /**
     * @param array<string> $matches
     */
    protected function formatNormalizedMatches(
        array $matches
    ): string {
        return implode(' ', $matches);
    }

    /**
     * @param array<string> $matches
     */
    protected function formatHtmlMatches(
        array $matches
    ): Markup {
        return Element::create('samp.number.banking.routing', function () use ($matches) {
            yield Element::create('span.value', $matches[0]);
            yield ' ';
            yield Element::create('span.value', $matches[1]);
            yield ' ';
            yield Element::create('span.value', $matches[2]);
        });
    }
}
