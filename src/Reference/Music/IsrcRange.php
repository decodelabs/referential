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

    protected const CanonicalPattern = '/^([A-Z]{2})([A-Z0-9]{3})$/';
    protected const CanonicalMaxLength = 5;
    protected const NormalPattern = '/^[a-zA-Z]{2}\-?[a-zA-Z0-9]{3}\*?$/';
    protected const NormalMaxLength = 7;
    protected const Example = 'GBMYV';

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
