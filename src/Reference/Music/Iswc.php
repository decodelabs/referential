<?php

/**
 * @package Referential
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Referential\Reference\Music;

use DecodeLabs\Referential\Reference;
use DecodeLabs\Referential\ReferenceTrait;
use DecodeLabs\Tagged as Html;
use DecodeLabs\Tagged\Markup;

class Iswc implements Reference
{
    use ReferenceTrait;

    public const CANONICAL_PATTERN = '/^([A-Z])([0-9]{3})([0-9]{3})([0-9]{3})([0-9])$/';
    public const CANONICAL_MAX_LENGTH = 11;
    public const NORMAL_PATTERN = '/^([a-zA-Z])\-?([0-9]{3})\.?([0-9]{3})\.?([0-9]{3})\-?([0-9])$/';
    public const NORMAL_MAX_LENGTH = 15;
    public const EXAMPLE = 'T3452468001';

    /**
     * Combine match parts
     *
     * @param array<string> $matches
     */
    protected function formatNormalizedMatches(
        array $matches
    ): string {
        return $matches[0] . '-' . $matches[1] . '.' . $matches[2] . '.' . $matches[3] . '-' . $matches[4];
    }

    /**
     * Convert canonical to html value
     *
     * @param array<string> $matches
     */
    protected function formatHtmlMatches(
        array $matches
    ): Markup {
        return Html::{'samp.number.music.iswc'}(function () use ($matches) {
            yield Html::{'span.value'}($matches[0]);
            yield Html::{'span.grammar'}('-');
            yield Html::{'span.value'}($matches[1]);
            yield Html::{'span.grammar'}('.');
            yield Html::{'span.value'}($matches[2]);
            yield Html::{'span.grammar'}('.');
            yield Html::{'span.value'}($matches[3]);
            yield Html::{'span.grammar'}('-');
            yield Html::{'span.value'}($matches[4]);
        }, [
            'title' => $this->canonical
        ]);
    }
}
