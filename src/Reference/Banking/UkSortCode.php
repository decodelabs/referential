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

class UkSortCode implements Reference
{
    use ReferenceTrait;

    public const string CanonicalPattern = '/^([0-9]{2})([0-9]{2})([0-9]{2})$/';
    public const int CanonicalMaxLength = 6;
    public const string NormalPattern = '/^([0-9]{2})[ -]?([0-9]{2})[ -]?([0-9]{2})$/';
    public const int NormalMaxLength = 8;
    public const string Example = '12-34-56';

    /**
     * @param array<string> $matches
     */
    protected function formatNormalizedMatches(
        array $matches
    ): string {
        return implode('-', $matches);
    }

    /**
     * @param array<string> $matches
     */
    protected function formatHtmlMatches(
        array $matches
    ): Markup {
        return Element::create('samp.number.banking.uk-sort-code', function () use ($matches) {
            yield Element::create('span.value', $matches[0]);
            yield Element::create('span.grammar', '-');
            yield Element::create('span.value', $matches[1]);
            yield Element::create('span.grammar', '-');
            yield Element::create('span.value', $matches[2]);
        }, [
            'title' => $this->canonical
        ]);
    }
}
