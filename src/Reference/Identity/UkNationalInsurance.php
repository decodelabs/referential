<?php

/**
 * @package Referential
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Referential\Reference\Identity;

use DecodeLabs\Referential\Reference;
use DecodeLabs\Referential\ReferenceTrait;
use DecodeLabs\Tagged\Element;
use DecodeLabs\Tagged\Markup;

class UkNationalInsurance implements Reference
{
    use ReferenceTrait;

    public const string CanonicalPattern = '/^([A-Z]{2})([0-9]{2})([0-9]{2})([0-9]{2})([A-Z])$/';
    public const int CanonicalMaxLength = 9;
    public const string NormalPattern = '/^([a-zA-Z]{2}) ?([0-9]{2}) ?([0-9]{2}) ?([0-9]{2}) ?([a-zA-Z])$/';
    public const int NormalMaxLength = 13;
    public const string Example = 'TN311258F';

    /**
     * Combine match parts
     *
     * @param array<string> $matches
     */
    protected function formatNormalizedMatches(
        array $matches
    ): string {
        return implode(' ', $matches);
    }

    /**
     * Convert canonical to html value
     *
     * @param array<string> $matches
     */
    protected function formatHtmlMatches(
        array $matches
    ): Markup {
        return Element::create('samp.number.identity.uk-ni', function () use ($matches) {
            yield Element::create('span.value', $matches[0]);
            yield ' ';
            yield Element::create('span.value', $matches[1]);
            yield ' ';
            yield Element::create('span.value', $matches[2]);
            yield ' ';
            yield Element::create('span.value', $matches[3]);
            yield ' ';
            yield Element::create('span.value', $matches[4]);
        }, [
            'title' => $this->canonical
        ]);
    }
}
