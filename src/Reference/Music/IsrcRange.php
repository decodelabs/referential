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

class IsrcRange implements Reference
{
    use ReferenceTrait;

    public const CANONICAL_PATTERN = '/^([A-Z]{2})([A-Z0-9]{3})$/';
    public const CANONICAL_MAX_LENGTH = 5;
    public const NORMAL_PATTERN = '/^[a-zA-Z]{2}\-?[a-zA-Z0-9]{3}\*?$/';
    public const NORMAL_MAX_LENGTH = 7;
    public const EXAMPLE = 'GBMYV';

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
        return Html::{'samp.number.music.isrc.range'}(function () use ($matches) {
            yield Html::{'span.value'}($matches[0]);
            yield Html::{'span.grammar'}('-');
            yield Html::{'span.value'}($matches[1]);
            yield Html::{'b.grammar'}('*');
        }, [
            'title' => $this->canonical
        ]);
    }
}
