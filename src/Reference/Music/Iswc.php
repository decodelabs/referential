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

class Iswc implements Reference
{
    use ReferenceTrait;

    public const string CanonicalPattern = '/^([A-Z])([0-9]{3})([0-9]{3})([0-9]{3})([0-9])$/';
    public const int CanonicalMaxLength = 11;
    public const string NormalPattern = '/^([a-zA-Z])\-?([0-9]{3})\.?([0-9]{3})\.?([0-9]{3})\-?([0-9])$/';
    public const int NormalMaxLength = 15;
    public const string Example = 'T3452468001';

    /**
     * @param array<string> $matches
     */
    protected function formatNormalizedMatches(
        array $matches
    ): string {
        return $matches[0] . '-' . $matches[1] . '.' . $matches[2] . '.' . $matches[3] . '-' . $matches[4];
    }

    /**
     * @param array<string> $matches
     */
    protected function formatHtmlMatches(
        array $matches
    ): Markup {
        return Element::create('samp.number.music.iswc', function () use ($matches) {
            yield Element::create('span.value', $matches[0]);
            yield Element::create('span.grammar', '-');
            yield Element::create('span.value', $matches[1]);
            yield Element::create('span.grammar', '.');
            yield Element::create('span.value', $matches[2]);
            yield Element::create('span.grammar', '.');
            yield Element::create('span.value', $matches[3]);
            yield Element::create('span.grammar', '-');
            yield Element::create('span.value', $matches[4]);
        }, [
            'title' => $this->canonical
        ]);
    }
}
