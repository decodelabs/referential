<?php

/**
 * @package Referential
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Referential\Reference\Music;

use DecodeLabs\Referential\Reference;
use DecodeLabs\Referential\ReferenceTrait;
use DecodeLabs\Tagged\Element;
use DecodeLabs\Tagged\Markup;

class IsrcRange implements Reference
{
    use ReferenceTrait;

    public const string CanonicalPattern = '/^([A-Z]{2})([A-Z0-9]{3})$/';
    public const int CanonicalMaxLength = 5;
    public const string NormalPattern = '/^[a-zA-Z]{2}\-?[a-zA-Z0-9]{3}\*?$/';
    public const int NormalMaxLength = 7;
    public const string Example = 'GBMYV';

    /**
     * Combine match parts
     *
     * @param array<string> $matches
     */
    protected function formatNormalizedMatches(
        array $matches
    ): string {
        return implode('-', $matches);
    }

    /**
     * Convert canonical to html value
     *
     * @param array<string> $matches
     */
    protected function formatHtmlMatches(
        array $matches
    ): Markup {
        return Element::create('samp.number.music.isrc.range', function () use ($matches) {
            yield Element::create('span.value', $matches[0]);
            yield Element::create('span.grammar', '-');
            yield Element::create('span.value', $matches[1]);
            yield Element::create('b.grammar', '*');
        }, [
            'title' => $this->canonical
        ]);
    }
}
