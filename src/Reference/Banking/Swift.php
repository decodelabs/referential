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

class Swift implements Reference
{
    use ReferenceTrait;

    public const string CanonicalPattern = '/^([a-zA-Z]{4})([a-zA-Z]{2})([0-9a-zA-Z]{2})([0-9a-zA-Z]{3})?$/';
    public const int CanonicalMaxLength = 11;
    public const string NormalPattern = self::CanonicalPattern;
    public const int NormalMaxLength = self::CanonicalMaxLength;
    public const string Example = 'BOFAUS3N';


    /**
     * Convert canonical to html value
     *
     * @param array<string> $matches
     */
    protected function formatHtmlMatches(
        array $matches
    ): Markup {
        return Element::create('samp.number.banking.swift', function () use ($matches) {
            yield Element::create('span.value', $matches[0]);
            yield Element::create('span.value', $matches[1]);
            yield Element::create('span.value', $matches[2]);
            yield Element::create('?span.value', $matches[3] ?? null);
        }, [
            'title' => $this->canonical
        ]);
    }
}
